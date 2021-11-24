<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //

    protected $table = 'products';
    protected $fillable = ['name', 'text', 'coverImage', 'firm_id', 'category','secondCategory'];

    public function views()
    {
        return $this->hasMany(Review::class,);
    }
}


