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
        
        // fake post request with animal info
        $response = $this->call('POST', '/api/orders', $order_data)->getOriginalContent();
        
        // check a customer is made and matches
        $customer = Customer::all()->first();
        $this->assertSame("Bilbo", $customer->first_name);
        
        // check we get back an owner with the right name from setup
        $this->assertSame("Bilbo", $response->customer->first_name);

        // check it's been added to the database
        $order = Order::all()->first();
        $this->assertSame(1.99, $order->price);

        
    }
}
