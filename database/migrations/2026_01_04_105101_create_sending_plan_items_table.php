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
        Schema::create('sending_plan_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sending_plan_id');
            $table->unsignedBigInteger('tool_id');
            $table->unsignedBigInteger('area_unit_id');

            $table->timestamps();

            $table->foreign('sending_plan_id')
                ->references('id')->on('sending_plans')
                ->cascadeOnDelete();

            $table->foreign('tool_id')->references('id')->on('tools');
            $table->foreign('area_unit_id')->references('id')->on('area_units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sending_plan_items');
    }
};
