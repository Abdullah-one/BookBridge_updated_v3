<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExchangePoint extends Model
{
    use HasFactory;

    protected $fillable=[
        'account_id',
        'residentialQuarter_id',
        'maxPackages',
        'no_packages',
        'location'
    ];

    /**
     * every exchangePoint belongs to one account
     *
     * @return BelongsTo
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * every exchangePoint can have zero or many bookDonations
     *
     * @return HasMany
     */
    public function bookDonations(): HasMany
    {
        return $this->HasMany(BookDonation::class,'exchangePoint_id');
    }

    public function residentialQuarter(): BelongsTo
    {
        return $this->belongsTo(ResidentialQuarter::class,'residentialQuarter_id');
    }
}
