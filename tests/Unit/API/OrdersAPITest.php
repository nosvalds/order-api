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

    public function testPostDuplicateCustomer()
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

    public function testGetOrder()
    {
        // create a customer in the DB
        Customer::create([
            "first_name" => "Bilbo",
            "last_name" => "Baggins",
            "email" => "email@fun.com",
        ]);

        $customerId = Customer::all()->first()->id;

        Order::create([
            "customer_id" => $customerId, // associate customer in DB with order
            "delivery_postcode" => "BS1 5DP",
            "order_description" => "2 barrels of wine",
            "price" => 1.99,
        ]);

        $orderFromDBID = Order::all()->first()->id;

        // fake a GET request
        $response = $this->withHeaders(["Accept" => "application/json"])->json('GET', "/api/orders/${orderFromDBID}")->getOriginalContent();
        
        // dd($response);
        // check we get back the owner we created in setup
        $this->assertSame("Bilbo", $response->customer->first_name);

        // check we get back the price we created in setup
        $this->assertSame(1.99, $response->price);
    }

    public function testPUTorder()
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
        $this->call('POST', '/api/orders', $order_data)->getOriginalContent();

        // create some updated Order Data in the format for the API
        $updated_order_data = [
            "customer" => 
            [
                "first_name" => "Bilbo",
                "last_name"  => "Baggins", 
                "email" => "bilbo@hole.com"
            ], 
            "delivery_postcode" => "BS1 59F", 
            "order_description" => "3 casks of wine",
            "price" => 2.99
        ];

        $orderFromDBID = Order::all()->first()->id;

        // PUT to update
        $this->call('PUT', "/api/orders/${orderFromDBID}", $updated_order_data)->getOriginalContent();

        // Check that data is updated
        $orderFromDB = Order::all()->first();

        // check the price matches
        $this->assertSame(2.99, $orderFromDB->price);

        // check the description matches
        $this->assertSame("3 casks of wine", $orderFromDB->order_description);
    }
}
