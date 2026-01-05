<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrow_requests', function (Blueprint $table) {
            $table->id();
            $table->date('request_date');

            $table->unsignedBigInteger('area_unit_id');
            $table->unsignedBigInteger('requester');

            $table->date('borrow_date');
            $table->date('return_date');
            $table->timestamps();

            $table->foreign('area_unit_id')->references('id')->on('area_units');
            $table->foreign('requester')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_requests');
    }
};
