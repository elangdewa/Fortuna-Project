<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('class_schedule_instances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('schedule_id')->constrained('class_schedules')->onDelete('cascade');
        $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
        $table->date('date'); // Tanggal aktual (misalnya: 2025-06-10)
        $table->time('start_time');
        $table->time('end_time');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedule_instances');
    }
};
