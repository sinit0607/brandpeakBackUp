<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;
    protected $table = "business";

    protected $fillable = [
        'logo','name','email','mobile_no','website','address','user_id','business_category_id','status','is_default'
    ];

    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    public function business_category()
    {
        return $this->hasOne("App\Models\BusinessCategory", "id", "business_category_id");
    }
}
