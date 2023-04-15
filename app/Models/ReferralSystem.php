<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ReferralSystem extends Model
{
    protected $table = "referral_system";

    protected $fillable = [
        'key_name', 'key_value',
    ];

    public static function get($key)
    {
        return ReferralSystem::where('key_name',$key)->first()->key_value;
    }

    public static function getReferralSystem($key)
    {
        $settings = Arr::pluck(ReferralSystem::all()->toArray(), 'key_value', 'key_name');
        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
