<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    private int $transaction_id;
    public function __construct(int $transaction_id)
    {
        $this->transaction_id=$transaction_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Transaction::find($this->transaction_id)->delete();
    }
}
