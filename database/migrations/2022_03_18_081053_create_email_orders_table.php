<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id');
            $table->string('email');
            $table->string('resource_code')->nullable();
            $table->string('status')->nullable();
            $table->boolean('payed')->nullable();
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
        Schema::dropIfExists('emailorders');
    }
}
