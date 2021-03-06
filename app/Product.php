<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','price','stock','note','category_id','user_id','status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
