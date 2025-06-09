<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
      Schema::create('payments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('membership_id')->nullable()->constrained('memberships')->nullOnDelete();
    $table->string('payment_method', 50)->nullable();
    $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');
    $table->string('transaction_id', 100)->nullable();
    $table->decimal('amount', 12, 2);
    $table->timestamp('payment_time')->nullable();
    $table->timestamps();
    $table->string('type')->nullable(); // class_registration, membership, personal_trainer, etc
    $table->unsignedBigInteger('reference_id')->nullable();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
