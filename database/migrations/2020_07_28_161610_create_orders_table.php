<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_postcode',10);
            $table->string('order_description',100);
            $table->float('price', 8, 2);

            // create the customer_id column
            $table->foreignId("customer_id")->unsigned()->nullable();

            // set up the foreign key constraint
            // this tells MySQL that the customer_id column
            // references the id column on the customers table
            $table->foreign("customer_id")->references("id")
            ->on("customers")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
