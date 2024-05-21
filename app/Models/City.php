<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'district'
    ];
    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(Admin::class);
    }

    /**
     * every City can has zero or many ResidentialQuarter
     *
     * @return HasMany
     */
    public function residentialQuarters():HasMany{
        return $this->hasMany(ResidentialQuarter::class,'city_id');
    }
}
