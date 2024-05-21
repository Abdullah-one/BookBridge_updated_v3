<?php

namespace App\Models;

use App\Http\Controllers\Api\User\CityController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Admin extends Model
{
    use HasFactory;

    protected $fillable=
        [
            'account_id',
        ];

    /**
     * every Admin belongs to one Account
     *
     * @return BelongsToMany
     */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class,'admin_city','admin_id','city_id');
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
