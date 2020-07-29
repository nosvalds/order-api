<?php

namespace Tests\Unit\API;

use App\Order;
use App\Customer;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class OrdersAPITest extends TestCase
{
    use RefreshDatabase;

    public function testPOSTOrder()
    {
        // create some Order Data in the format for the API
        $order_data = [
            "customer" => 
            [
                "first_name" => "Bilbo",
                "last_name"  => "Baggins", 
                "email" => "bilbo@hole.com"
            ], 
            "delivery_postcode" => "BS1 59F", 
            "order_description" => "2 casks of wine",
            "price" => 1.99
        ];
        
        // fake post request with order info
        $response = $this->call('POST', '/api/orders', $order_data)->getOriginalContent();
        
        // check a customer is created and matches what we POST'd
        $customer = Customer::all()->first();
        $this->assertSame("Bilbo", $customer->first_name);

        // check we get back an owner in the response with the right name
        $this->assertSame("Bilbo", $response->customer->first_name);

        // check that the order has been added to the database
        $order = Order::all()->first();
        $this->assertSame(1.99, $order->price);        
    }

    public function testPOSTduplicateCustomer()
    {
        // create a customer in the DB
        $customer = Customer::create([
            "first_name" => "Bilbo",
            "last_name" => "Baggins",
            "email" => "bilbo@hole.com",
        ]);

        // create a 2nd customer in the DB
        Customer::create([
            "first_name" => "Frodo",
            "last_name" => "Baggins",
            "email" => "frodo@hole.com",
        ]);

        // create some Order Data in the format for the API using the same customer
        $order_data = [
            "customer" => 
            [
                "first_name" => "Bilbo",
                "last_name"  => "Baggins", 
                "email" => "bilbo@hole.com"
            ], 
            "delivery_postcode" => "BS1 59F", 
            "order_description" => "2 casks of wine",
            "price" => 1.99
        ];
        
        // fake post request with order info
        $response = $this->call('POST', '/api/orders', $order_data)->getOriginalContent();

        // check that there are only 2 customers in the database

        $this->assertSame(2, Customer::all()->count());
    }
}
