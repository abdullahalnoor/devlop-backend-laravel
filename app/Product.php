<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name','price','description','user_id','image'];
    public function category(){
        return $this->belongsTo('App\Category');
    }
}
