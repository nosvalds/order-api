<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // fillable properties
    protected $fillable = ["first_name", "last_name", "email"];

    // plural, as an article can have multiple orders
    public function orders()
    {
        // use hasMany relationship method
        return $this->hasMany(Order::class);
    }
}
