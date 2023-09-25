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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('branch');
            $table->integer('price')->nullable();
            $table->string('size')->nullable();
            $table->string('first_image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('type')->nullable();
            $table->string('material')->nullable();
            $table->string('address')->nullable();
            $table->integer('payed')->nullable();
            $table->integer('print_payed')->nullable();
            $table->string('tenant')->nullable();
            $table->string('tenant_identification_code')->nullable();
            $table->string('tenant_number')->nullable();
            $table->string('tenant_email')->nullable();
            $table->date('start_date')->nullable();;
            $table->date('end_date')->nullable();;
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
        Schema::dropIfExists('banners');
    }
};
