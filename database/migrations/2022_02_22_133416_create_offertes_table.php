<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffertesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offertes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('summary');
            $table->string('status')->default('aanvraag');
            $table->string('reference')->nullable();
            $table->string('company_id');
            $table->integer('estimated_value');
            $table->string('estimated_closing_date');
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
        Schema::dropIfExists('offertes');
    }
}
