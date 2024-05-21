<?php

namespace App\Jobs;

use App\Models\BookDonation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AddToRemovalList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public int $bookDonation_id;
    public function __construct(int $bookDonation_id)
    {
        $this->bookDonation_id=$bookDonation_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        BookDonation::find($this->bookDonation_id)->update([
            'isRemovable'=>true
        ]);
    }
}
