<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       Schema::create('class_schedules', function (Blueprint $table) {
    $table->id();
    $table->foreignId('class_id')->nullable()->constrained('fitness_classes')->nullOnDelete();
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->nullable();
    $table->enum('day_of_week', ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'])->nullable();
    $table->date('date')->nullable();
    $table->time('start_time')->nullable();
    $table->time('end_time')->nullable();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
