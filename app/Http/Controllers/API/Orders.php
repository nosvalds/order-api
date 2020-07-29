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
    
        // check if there is already a customer in the database
        $existing_customer = Customer::where('email', $customer_data['customer']['email']);
        if ($existing_customer->count() === 1) {
            // use existing customer if it's already there
            $customer = $existing_customer;
        } else {
            // create a new customer if there is no customer already in the DB
            $customer = Customer::create($customer_data['customer']);
        }

        // create the order associated with the customer
        $order = $customer->orders()->create($order_data);

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
