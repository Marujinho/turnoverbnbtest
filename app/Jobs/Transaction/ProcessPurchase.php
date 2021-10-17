<?php

namespace App\Jobs\Transaction;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Domain\Balance\BalanceRepository;
use Domain\Transaction\TransactionRepository;

class ProcessPurchase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $user_bank;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $user_bank)
    {
        $this->request = $request;
        $this->user_bank = $user_bank;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TransactionRepository $transaction_repo, BalanceRepository $balance_repo)
    {
        //$transaction_repo->storePurchase($this->request);

        dd($this->user_bank);

        $new_balance = $balance_repo->subtractBalance($this->user_bank->pivot->balance, $this->request->amount);
        $balance_repo->updateBalance($this->user_bank, $new_balance);

        return;
    }
}
