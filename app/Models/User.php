<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile_no',
        'image',
        'status',
        'subscription_id',
        'subscription_start_date',
        'subscription_end_date',
        'user_language',
        'login_type',
        'api_token',
        'email_verified_at',
        'user_type',
        'business_limit',
        "referral_code",
        "current_balance",
        "total_balance",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function subscription()
    {
        return $this->hasOne("App\Models\Subscription", "id", "subscription_id");
    }

    public function language()
    {
        return $this->hasOne("App\Models\Language", "id", "user_language");
    }
}
