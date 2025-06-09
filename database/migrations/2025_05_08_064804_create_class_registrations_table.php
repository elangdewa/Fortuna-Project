<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('class_id')->nullable()->constrained('fitness_classes')->nullOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('class_schedules')->nullOnDelete();
            $table->timestamp('registered_at')->useCurrent();
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->enum('status', ['pending', 'active', 'cancelled'])->default('pending');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_registrations');
    }
};
