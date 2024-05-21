<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResidentialQuarter extends Model
{
    use HasFactory;
    protected $fillable=[
        'city_id',
        'name'
    ];

    /**
     * every ResidentialQuarter belongs to one City
     *
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class,'city_id');
    }

    /**
     * every ResidentialQuarter can has zero or many ExchangePoint
     *
     * @return HasMany
     */
    public function exchangePoints(): HasMany
    {
        return $this->hasMany(ExchangePoint::class,'residentialQuarter_id');
    }
}
