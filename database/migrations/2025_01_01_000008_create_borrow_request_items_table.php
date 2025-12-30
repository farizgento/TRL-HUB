<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrow_request_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrow_request_id')
                ->constrained('borrow_requests')
                ->cascadeOnDelete();
            $table->string('item_no')->nullable();
            $table->string('permintaan_alat');
            $table->foreignId('tool_id')
                ->nullable()
                ->constrained('tools')
                ->nullOnDelete();
            $table->string('return_condition')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_request_items');
    }
};
