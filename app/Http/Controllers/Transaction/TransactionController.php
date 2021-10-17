<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use Domain\Transaction\TransactionRepository;
use Domain\Balance\BalanceRepository;
use Domain\User\UserRepository;
use Illuminate\Http\Request;
use Domain\Transaction\Requests\StoreDepositRequest;
use Domain\Transaction\Requests\StorePurchaseRequest;
use Domain\Transaction\Requests\AuthorizeTransactionRequest;
use Auth;
use App\Jobs\Transaction\ProcessPurchase;

class TransactionController extends Controller
{
    protected $transaction;
    protected $user;
    protected $balance;

    public function __construct(TransactionRepository $transaction, UserRepository $user,
                                BalanceRepository $balance)
    {
        $this->transaction = $transaction;
        $this->user = $user;
        $this->balance = $balance;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $user_bank = $this->user->getUserBank($user);
        $user_data = $this->user->prepareUserData($user_bank);

        if($user_data['role'] == 'customer'){
            $transactions = $this->transaction->listUserTransactions($user_data['relationshipId']);
        }else{
            $transactions = $this->transaction->listBankTransactions($user->current_bank);
        }

        return view('transactions.list', [
            'transactions' => $transactions,
            'user_data' => $user_data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDeposit()
    {
        $user = Auth::user();
        $user_bank = $this->user->getUserBank($user);
        $user_data = $this->user->prepareUserData($user_bank);

        return view('transactions.deposit', [
          'user_data' => $user_data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPurchase()
    {
        $user = Auth::user();
        $user_bank = $this->user->getUserBank($user);
        $user_data = $this->user->prepareUserData($user_bank);

        return view('transactions.purchase', [
          'user_data' => $user_data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDeposit(StoreDepositRequest $request)
    {
        $user = Auth::user();
        $user_bank = $this->user->getUserBank($user);
        $user_data = $this->user->prepareUserData($user_bank);

        $path = $request->file('check')->store('customers/checks');
        $file_name = explode('customers/checks/', $path );
        $request->file('check')->move(public_path('customers/checks'), $file_name[1]);
        $request->path = $path;
        $request->bank_id = $user->current_bank;
        $request->relationship_id = $user_data['relationshipId'];

        $this->transaction->storeDeposit($request);

        return redirect()->route('transaction.deposit')->with('success', 'Your deposit is being analized by an admin, if everything checks out the amount will be added to your balance');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePurchase(StorePurchaseRequest $request)
    {
        $user = Auth::user();
        $user_bank = $this->user->getUserBank($user);
        $has_balance = $this->balance->hasEnoughBalance($user_bank->pivot->balance, $request->amount);

        if(!$has_balance) {
            return redirect()->route('transaction.purchase')->withErrors("You don't have enough balance to complete this transaction");
        }

        // $extra_data = ['bank_id' => $user->current_bank, 'relationship_id' => $user_bank->pivot->id];
        // $request_data = array_merge($request->toArray(), $extra_data);
        $request->bank_id = $user->current_bank;
        $request->relationship_id = $user_bank->pivot->id;

        //job aqui
        // ProcessPurchase::dispatch($request_data, $user_bank);
        $this->transaction->storePurchase($request);
        $new_balance = $this->balance->subtractBalance($user_bank->pivot->balance, $request->amount);
        $this->balance->updateBalance($user_bank, $new_balance);

        //$user_data = $this->user->prepareUserData($user_bank);

        return redirect()->route('transaction.purchase')->with('success', 'Transaction has been completed successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->transaction->getTransaction($id);

        if(!$transaction) {
           abort(404);
        }

        $user = Auth::user();

        if($transaction->bank_id != $user->current_bank){
            abort(403);
        }

        $transaction_user_id = $transaction->bankUser()->first()->user_id;
        $user = $this->user->getUser($transaction_user_id);

        $transaction_data = $this->transaction->prepareTransactionData($user, $transaction);

        return view('transactions.detail', [
          'transaction_data' => $transaction_data
        ]);
    }

    public function authorizeTransaction(AuthorizeTransactionRequest $request, $transaction_id)
    {
        $transaction = $this->transaction->getTransaction($transaction_id);

        if(!$transaction) {
           abort(404);
        }

        $user = Auth::user();

        if($transaction->bank_id != $user->current_bank || $transaction->type != 'deposit') {
            abort(403);
        }

        $authorized = $this->transaction->authorize($request->authorization, $transaction);

        if($authorized) {
            //job aqui
            $transaction_user_id = $transaction->bankUser()->first()->user_id;
            $transaction_user = $this->user->getUser($transaction_user_id);
            $transaction_user_bank = $this->user->getUserBank($transaction_user);
            $new_balance = $this->balance->addBalance($transaction_user_bank->pivot->balance, $transaction->amount);
            $this->balance->updateBalance($transaction_user_bank, $new_balance);
        }

        return redirect()->route('transaction.index')->with('success', 'The deposit status has been updated successfully');
    }

}
