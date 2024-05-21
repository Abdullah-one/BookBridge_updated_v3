<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userName',
        'phoneNumber',
        'phoneVerified',
        'password',
        'email',
        'role',
        'exist'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * every Account can has zero or one User.
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class,'account_id');
    }

    /**
     * every Account can has zero or one ExchangePoint.
     *
     * @return HasOne
     */
    public function exchangePoint(): HasOne
    {
        return $this->hasOne(ExchangePoint::class,'account_id');
    }

    /**
     * every Account can has zero or many Chats
     *
     * @return HasMany
     */

    /**
     * every Account can has zero or one Admin.
     *
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class,'account_id');
    }

    public function deviceTokens():HasMany
    {
        return $this->hasMany(DeviceToken::class,'account_id');
    }



    public function routeNotificationForFcm($notification=null)
    {
        return $this->DeviceTokens()->pluck('token')->toArray();
    }
}
