<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sending_plans', function (Blueprint $table) {
        
        $table->id();
        $table->date('send_date');

        $table->unsignedBigInteger('borrow_request_id')->nullable();

        $table->boolean('status_approval')->default(false);
        $table->unsignedBigInteger('approved_by')->nullable();

        $table->timestamps();

        $table->foreign('borrow_request_id')->references('id')->on('borrow_requests');
        $table->foreign('approved_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sending_plans');
    }
};
