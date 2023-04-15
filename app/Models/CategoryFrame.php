<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryFrame extends Model
{
    use HasFactory;
    protected $table = "category_frame";

    protected $fillable = [
        'category_id','user_id','language_id','frame_image','status',"paid","height","width","image_type","aspect_ratio"
    ];

    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    public function category()
    {
        return $this->hasOne("App\Models\Category", "id", "category_id");
    }

    public function language()
    {
        return $this->hasOne("App\Models\Language", "id", "language_id");
    }
}
