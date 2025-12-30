<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->string('asset_no')->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('tool_name');
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('tool_categories')
                ->nullOnDelete();
            $table->foreignId('location_id')
                ->nullable()
                ->constrained('tool_locations')
                ->nullOnDelete();
            $table->string('condition_status')->default('baik');
            $table->string('availability_status')->default('tersedia');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
