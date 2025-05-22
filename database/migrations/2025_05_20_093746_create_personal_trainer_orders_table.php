<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('personal_trainer_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('trainer_id')->nullable();
            $table->date('order_date')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->nullable();
            $table->integer('sessions')->default(10);
            $table->enum('payment_status', ['unpaid', 'paid', 'failed'])->default('unpaid');
            $table->decimal('total_price', 10, 2)->default(200000);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('trainer_id')->references('id')->on('personal_trainers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_trainer_orders');
    }
};
