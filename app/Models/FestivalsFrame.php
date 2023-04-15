<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FestivalsFrame extends Model
{
    use HasFactory;
   
    protected $table = "festivals_frame";

    protected $fillable = [
        'festivals_id','user_id','language_id','frame_image','status',"paid","height","width","image_type","aspect_ratio"
    ];

    public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id");
    }

    public function festivals()
    {
        return $this->hasOne("App\Models\Festivals", "id", "festivals_id");
    }

    public function language()
    {
        return $this->hasOne("App\Models\Language", "id", "language_id");
    }
}
