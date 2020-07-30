<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Order;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\OrderResource;
use Illuminate\Http\Request;

class Orders extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get the request data
        $customer_data = $request->only('customer');
        $order_data = $request->only('delivery_postcode', 'order_description','price');
        $email = $customer_data['customer']['email'];

        // check if there is already a customer in the database by email
        $existing_customer = Customer::where('email', $email);

        if ($existing_customer->count() === 1) {
            // use existing customer if it's already there
            $order = $existing_customer->first()->orders()->create($order_data);
        } else {
            // create a new customer if there is no customer already in the DB
            $customer = Customer::create($customer_data['customer']);

            // create the order associated with the customer
            $order = $customer->orders()->create($order_data);
        }

        // return the order resource
        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        // get order data
        $order_data = $request->only('delivery_postcode', 'order_description','price');

        // save data
        $order->fill($order_data)->save();

        // return
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
