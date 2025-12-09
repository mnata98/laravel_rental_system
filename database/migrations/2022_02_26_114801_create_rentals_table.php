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
        Schema::create('rentals', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('car_id');
            // assuming user system uses default users table or employees? 
            // The original had eid (employee id presumably). Let's keep it generic or link to users if needed.
            // But looking at original `leases` it had `eid` and `pid`.
            // Let's assume for now we might want to link to a customer. 
            // But strict requirement wasn't given for customers, just "User Authentication" was mentioned in my plan.
            // Existing `users` table exists.
            // existing `employees` table exists.
            // Let's assume `user_id` for the customer/user renting.
            $table->unsignedBigInteger('user_id')->nullable(); 
            
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_cost', 10, 2);
            $table->string('status')->default('pending'); // pending, active, completed, cancelled
            
            $table->timestamps();

            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            // $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
};
