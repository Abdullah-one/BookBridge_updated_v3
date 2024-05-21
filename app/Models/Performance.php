<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $fillable=[
        'exchangePoint_id',
        'year',
        'month',
        'no_addedDonation',
        'no_bookedDonation',
        'no_canceledDonationFromDonor',
        'no_canceledDonationFromBeneficiary',
        'no_receivedDonation',
        'no_removedDonation',
        'no_rejectedDonation',
        'no_deliveredDonation',
        'no_rejectedDonationFromBeneficiary',
        'no_reachingMaxPackages'
    ];
}
