<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";

    protected $fillable = [
        'title','image','status','description','price','discount_price','product_category_id'
    ];

    public function ProductCategory()
    {
        return $this->hasOne("App\Models\ProductCategory", "id", "product_category_id");
    }
}
