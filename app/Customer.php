<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // fillable properties
    protected $fillable = ["first_name", "last_name", "email"];
}
