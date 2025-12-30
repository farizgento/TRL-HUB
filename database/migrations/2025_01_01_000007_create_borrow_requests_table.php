<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrow_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_no')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('area_unit_id')
                ->nullable()
                ->constrained('area_units')
                ->nullOnDelete();
            $table->string('job_type')->nullable();
            $table->string('work_location')->nullable();
            $table->date('requested_at')->nullable();
            $table->date('planned_start_date')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->string('status')->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->foreignId('approved_l1_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('approved_l1_at')->nullable();
            $table->text('approved_l1_note')->nullable();
            $table->foreignId('approved_final_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('approved_final_at')->nullable();
            $table->text('approved_final_note')->nullable();
            $table->foreignId('dispatched_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('dispatched_at')->nullable();
            $table->text('dispatch_note')->nullable();
            $table->foreignId('returned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('returned_at')->nullable();
            $table->text('return_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrow_requests');
    }
};
