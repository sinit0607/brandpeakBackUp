<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class WhatsAppSetting extends Model
{
    protected $table = "whatsapp_setting";

    protected $fillable = [
        'key_name', 'key_value',
    ];

    public static function get($key)
    {
        return WhatsAppSetting::whereKeyName($key)->first()->key_value;
    }

    public static function getWhatsAppSetting($key)
    {
        $settings = Arr::pluck(WhatsAppSetting::all()->toArray(), 'key_value', 'key_name');
        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
