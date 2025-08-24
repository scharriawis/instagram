<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    
    //Relacion de muchos a uno
    public function users() {
        return $this->belongsTo('App\Models\user', 'user_id');
    }
    
    //Relacion de muchos a uno
    public function images() {
        return $this->belongsTo('App\Models\Image', 'image_id');
    }
}
