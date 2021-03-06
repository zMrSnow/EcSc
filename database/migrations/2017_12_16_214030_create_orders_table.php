<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer("user_id")->unsigned()->index();
            $table->text("cart");
            $table->string("adress");
            $table->string("city");
            $table->string("psc");
            $table->string("name");
            $table->float("price")->unsigned();
            $table->integer("weight")->unsigned();
            $table->integer("shipping_type")->unsigned()->index();
            $table->integer("status")->default(0);
            $table->string("payment_id")->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("shipping_type")->references("id")->on("shippings")->onDelete("cascade");
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
