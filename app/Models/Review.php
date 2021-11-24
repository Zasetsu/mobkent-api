<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //

    protected $table = 'views';
    protected $fillable = ['user_id', 'product_id'];



}


