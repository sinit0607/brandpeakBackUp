<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ApiSetting extends Model
{
    protected $table = "api_setting";

    protected $fillable = [
        'key_name', 'key_value',
    ];

    public static function get($key)
    {
        return ApiSetting::whereName($key)->first()->key_value;
    }

    public static function getApiSetting($key)
    {
        $settings = Arr::pluck(ApiSetting::all()->toArray(), 'key_value', 'key_name');
        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
