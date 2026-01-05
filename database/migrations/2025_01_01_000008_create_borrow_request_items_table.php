<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrow_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrow_request_id');
            $table->unsignedBigInteger('tool_id');
            $table->timestamps();

            $table->foreign('borrow_request_id')
                ->references('id')->on('borrow_requests')
                ->cascadeOnDelete();

            $table->foreign('tool_id')
                ->references('id')->on('tools');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_request_items');
    }
};
