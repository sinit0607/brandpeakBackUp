<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class StorageSetting extends Model
{
    protected $table = "storage_setting";

    protected $fillable = [
        'key_name', 'key_value',
    ];

    public static function get($key)
    {
        return StorageSetting::whereKeyName($key)->first()->key_value;
    }

    public static function getStorageSetting($key)
    {
        $settings = Arr::pluck(StorageSetting::all()->toArray(), 'key_value', 'key_name');
        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
