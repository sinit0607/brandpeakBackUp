<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $table = "subscription_plan";

    protected $fillable = [
        'plan_name','duration','duration_type','plan_price','discount_price','status','plan_detail',
        'business_limit','google_product_enable','google_product_id'
    ];
}
