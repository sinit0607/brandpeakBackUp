<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class NotificationSetting extends Model
{
    protected $table = "notification_setting";

    protected $fillable = [
        'key_name', 'key_value',
    ];

    public static function get($key)
    {
        return NotificationSetting::whereName($key)->first()->key_value;
    }

    public static function getNotificationSetting($key)
    {
        $settings = Arr::pluck(NotificationSetting::all()->toArray(), 'key_value', 'key_name');
        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
