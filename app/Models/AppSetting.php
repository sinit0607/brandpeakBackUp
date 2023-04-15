<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class AppSetting extends Model
{
    protected $table = "app_setting";

    protected $fillable = [
        'key_name', 'key_value',
    ];

    public static function get($key)
    {
        return AppSetting::whereName($key)->first()->key_value;
    }

    public static function getAppSetting($key)
    {
        $settings = Arr::pluck(AppSetting::all()->toArray(), 'key_value', 'key_name');
        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
