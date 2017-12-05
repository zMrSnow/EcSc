<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("product_id")->unsigned()->index();
            $table->integer("sizer_id")->unsigned()->index();
            $table->integer("quantities");
            $table->timestamps();

            $table->foreign("product_id")->references("id")->on("products")->onDelete("cascade");
            $table->foreign("sizer_id")->references("id")->on("sizers")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
