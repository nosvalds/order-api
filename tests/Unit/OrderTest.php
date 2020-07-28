<?php

namespace Tests\Unit;

use App\Order;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testFillable()
    {
        $order = new Order([
            "customer_id" => 2,
            "delivery_postcode" => "BS1 5DP",
            "order_description" => "2 barrels of wine",
            "price" => 1.99,
            "danger" => "Aaaargh!",
        ]);

        // delivery_postcode should be set, as it's in $fillable
        $this->assertSame("BS1 5DP", $order->delivery_postcode);

        // order_description should be set, as it's in $fillable
        $this->assertSame("2 barrels of wine", $order->order_description);

        // price should be set, as it's in $fillable
        $this->assertSame(1.99, $order->price);
        
        // customerID should be set, as it's in $fillable
        $this->assertSame(2, $order->customer_id);

        // danger shouldn't be set, as it's not in $fillable
        $this->assertSame(null, $order->danger);
    }

    public function testOrderDatabase()
    {
        // create a customer in the DB
        Customer::create([
            "first_name" => "Bilbo",
            "last_name" => "Baggins",
            "email" => "email@fun.com",
        ]);
       
        Order::create([
            "customer_id" => Customer::all()->first()->id, // associate customer in DB with order
            "delivery_postcode" => "BS1 5DP",
            "order_description" => "2 barrels of wine",
            "price" => 1.99,
        ]);

        // get the first Order back from the database
        $orderFromDB = Order::all()->first();

        // check the postcodes match
        $this->assertSame("BS1 5DP", $orderFromDB->delivery_postcode);

        // check the price matches
        $this->assertSame(1.99, $orderFromDB->price);

        // check the customer id matches
        $this->assertSame(Customer::all()->first()->id, $orderFromDB->customer_id);
    }
}
