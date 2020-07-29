<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\Order;
use App\Http\Controllers\Controller;
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
        $order_data = collect($request->only('delivery_postcode', 'order_description','price'));
        
        // create a new customer
        $customer = Customer::create($customer_data['customer']);

        $order_data->put('customer_id', $customer->id);
        
        // create the order
        $order = Order::create($order_data->all());

        return $order;
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
