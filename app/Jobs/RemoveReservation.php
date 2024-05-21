<?php

namespace App\Jobs;

use App\Http\Controllers\Api\User\BookDonationController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class RemoveReservation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    private int $reservation_id;

    public function __construct(int $reservation_id)
    {
        $this->reservation_id=$reservation_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $reservation=DB::table('reservations')->find($this->reservation_id);
        $reservation->delete();
    }
}
