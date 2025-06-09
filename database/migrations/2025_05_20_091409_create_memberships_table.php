<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
      Schema::create('memberships', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->string('membership_type', 100)->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->enum('status', ['active', 'inactive'])->nullable();
    $table->date('start_date')->nullable();
    $table->date('end_date')->nullable();
    $table->enum('payment_status', ['paid', 'unpaid'])->nullable();
    $table->timestamps();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
