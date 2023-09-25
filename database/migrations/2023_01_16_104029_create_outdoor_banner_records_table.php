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
        Schema::create('outdoor_banner_records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('banner_id');
            $table->integer('price')->nullable();
            $table->string('size')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->integer('payed')->nullable();
            $table->string('owner')->nullable();
            $table->string('owner_identification_code')->nullable();
            $table->string('owner_number')->nullable();
            $table->string('owner_email')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
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
        Schema::dropIfExists('outdoor_banner_records');
    }
};
