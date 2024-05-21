<?php

namespace App\Jobs;

use App\Models\BookDonation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class canAcceptEvenItIsNotWaitedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private int $bookDonation_id;

    public function __construct(int $bookDonation_id)
    {
        $this->bookDonation_id=$bookDonation_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $bookDonation=BookDonation::find($this->bookDonation_id);
        if(!$bookDonation){
            return;
        }
        if(!$bookDonation->canAcceptEvenItIsNotWaited){
            return;
        }
        $bookDonation->update(['canAcceptEvenItIsNotWaited' => false]);
        $bookDonation->exchangePoint()->decrement('no_packages');
    }
}
