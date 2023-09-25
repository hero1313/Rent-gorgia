<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outdoors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('price')->nullable();
            $table->string('size')->nullable();
            $table->string('image')->nullable();
            $table->string('material')->nullable();
            $table->string('address')->nullable();
            $table->integer('payed')->nullable();
            $table->string('owner')->nullable();
            $table->string('owner_identification_code')->nullable();
            $table->string('owner_number')->nullable();
            $table->string('towner_email')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('month')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('outdoors');
    }
};
