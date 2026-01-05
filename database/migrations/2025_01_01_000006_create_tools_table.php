<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tools', function (Blueprint $table) {

            $table->id();
            $table->string('name');
            $table->string('nomer_asset')->nullable();
            $table->string('barcode')->nullable();

            // lokasi terakhir
            $table->unsignedBigInteger('current_location_id')->nullable();

            // status terakhir
            $table->string('current_status')->default('tersedia');
            // tersedia | rusak | dipinjam | diperbaiki

            // kondisi terakhir
            $table->string('condition')->default('baik');
            // baik | rusak ringan | rusak berat | hilang
            
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('current_location_id')
                  ->references('id')
                  ->on('area_units')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
