<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'category_id'
    ];

    public $timestamps = false;


    public function category()
    {
        return $this->belongsTo('\App\Models\Category');
    }
}
