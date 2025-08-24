<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $table = 'images';
    
    //Relacion de uno a muchos
    public function comments() {
        return $this->hasMany('App\Models\Comment')->orderBy('updated_at', 'desc');
    }
    
    //Relacion de uno a muchos
    public function likes() {
        return $this->hasMany('App\Models\Like');
    }
    
    //Relacion de muchos a uno
    public function users() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
