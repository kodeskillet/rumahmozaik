<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['productName'];
    protected $table = 'product';
    // protected $appends = ['catalogName'];
}
