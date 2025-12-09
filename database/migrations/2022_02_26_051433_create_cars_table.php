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
        Schema::create('cars', function (Blueprint $table) {
            $table->id('id');
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('plate_number')->unique();
            $table->string('type'); // Sedan, SUV, etc.
            $table->decimal('daily_rate', 8, 2);
            $table->string('image')->nullable();
            $table->string('status')->default('available'); // available, rented, maintenance
            $table->longText('description')->nullable();
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
        Schema::dropIfExists('cars');
    }
};
