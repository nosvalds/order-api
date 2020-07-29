<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // fillable properties
    protected $fillable = ["delivery_postcode", "order_description", "price", "customer_id"];

    // setup the other side of the relationship
    // use singular, as a order only has one customer
    public function customer()
    {
        // a order belongs to an customer
        return $this->belongsTo(Customer::class);
}
}
