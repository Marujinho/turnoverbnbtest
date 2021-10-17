<?php

namespace Domain\Transaction;


class TransactionRepository
{

    protected $model;

    /**
     * AssessmentRepository constructor.
     * @param \Domain\Transaction\Transaction $model
     */
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function listUserTransactions($bank_user_id)
    {
        return $this->model->where('bank_user_id', $bank_user_id)->get();
    }

    public function listBankTransactions($bank_id)
    {
        return $this->model->where('bank_id', $bank_id)->where('type', 'deposit')->get();
    }

    public function storeDeposit($request)
    {
        $data = [
          'bank_id' => $request->bank_id,
          'bank_user_id' => $request->relationship_id,
          'type' => 'deposit',
          'check' => $request->path,
          'description' => $request->description,
          'amount' => $request->amount,
          'customer_current_balance' => 0,
          'authorization_status' =>'pending'
        ];

        $this->model->fill($data);
        return $this->model->save();
    }

    public function storePurchase($request)
    {
        $data = [
          'bank_id' => $request->bank_id,
          'bank_user_id' => $request->relationship_id,
          'type' => 'purchase',
          'check' => null,
          'description' => $request->description,
          'amount' => $request->amount,
          'customer_current_balance' => 0,
          'authorization_status' =>'authorized'
        ];

        $this->model->fill($data);
        return $this->model->save();
    }

    public function getTransaction($transaction_id)
    {
        return $this->model->find($transaction_id);
    }

    public function authorize($action, $transaction)
    {
        if($action == 'authorize'){
            $transaction->authorization_status = 'authorized';
            $transaction->save();
            return true;
        }else{
            $transaction->authorization_status = 'rejected';
            $transaction->save();
            return false;
        }
    }

    public function prepareTransactionData($user, $transaction)
    {
        return [
            'user_name' => $user->name,
            'description' => $transaction->description,
            'amount' => $transaction->amount,
            'check' => $transaction->check,
            'transaction_id' => $transaction->id,
            'authorization_status' => $transaction->authorization_status,
            'type' => $transaction->type,
            'date' => $transaction->created_at
        ];
    }

}
