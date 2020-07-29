<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer' => [
                'first_name' => $this->customer->first_name,
                'last_name' => $this->customer->last_name,
                'email' => $this->customer->email
            ],
            'delivery_postcode' => $this->delivery_postcode, 
            'order_description' => $this->order_description, 
            'price' => $this->price,
        ];
    }
}
