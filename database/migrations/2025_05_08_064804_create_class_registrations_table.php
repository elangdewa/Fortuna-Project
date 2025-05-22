<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->timestamp('registered_at')->useCurrent();
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->enum('status', ['pending', 'active', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('class_id')->references('id')->on('fitness_classes')->onDelete('set null');
            $table->foreign('schedule_id')->references('id')->on('class_schedules')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_registrations');
    }
};
