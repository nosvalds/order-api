<?php

namespace Tests\Unit;

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
            "delivery_postcode" => "Bilbo",
            "order_description" => "Baggins",
            "price" => 1.99,
            "danger" => "Aaaargh!",
        ]);

        // delivery_postcode should be set, as it's in $fillable
        $this->assertSame("Bilbo", $order->delivery_postcode);

        // order_description should be set, as it's in $fillable
        $this->assertSame("Baggins", $order->order_description);

        // price should be set, as it's in $fillable
        $this->assertSame(1.99, $order->price);

        // danger shouldn't be set, as it's not in $fillable
        $this->assertSame(null, $order->danger);
    }
}
