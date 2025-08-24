<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    
    //Relacion de muchos a uno
    public function users() {
        return $this->belongsTo('App\Models\user', 'user_id');
    }
    
    //Relacion de muchos a uno
    public function images() {
        return $this->belongsTo('App\Models\image', 'image_id');
    }
}
