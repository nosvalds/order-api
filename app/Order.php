<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // fillable properties
    protected $fillable = ["delivery_postcode", "order_description", "price", "customer_id"];
}
