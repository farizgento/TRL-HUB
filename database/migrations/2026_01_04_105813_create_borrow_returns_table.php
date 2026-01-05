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
        Schema::create('borrow_returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sending_plan_id');

            $table->string('item_condition');
            $table->text('note')->nullable();

            $table->timestamps();

            $table->foreign('sending_plan_id')
                ->references('id')->on('sending_plans');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_returns');
    }
};
