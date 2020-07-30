<?php

namespace Tests\Unit;

use App\Customer;
use App\Order;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function testFillable()
    {
        $customer = new Customer([
            "first_name" => "Bilbo",
            "last_name" => "Baggins",
            "email" => "email@fun.com",
            "danger" => "Aaaargh!",
        ]);
        // first_name should be set, as it's in $fillable
        $this->assertSame("Bilbo", $customer->first_name);

        // last_name should be set, as it's in $fillable
        $this->assertSame("Baggins", $customer->last_name);

        // email should be set, as it's in $fillable
        $this->assertSame("email@fun.com", $customer->email);

        // danger shouldn't be set, as it's not in $fillable
        $this->assertSame(null, $customer->danger);
    }

    public function testCustomerDatabase()
    {
        Customer::create([
            "first_name" => "Bilbo",
            "last_name" => "Baggins",
            "email" => "email@fun.com",
        ]);

        // get the first customer back from the database
        $customerFromDB = Customer::all()->first();

        // check the titles match
        $this->assertSame("Bilbo", $customerFromDB->first_name);
    }

    public function testRelationship()
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

        $price = Customer::all()->first()->orders->first()->price; 
        
        $this->assertSame('1.99', $price);
        
    }
}
