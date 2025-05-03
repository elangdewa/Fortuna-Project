<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/[timestamp]_create_fitness_classes_table.php
public function up()
{
    Schema::create('fitness_classes', function (Blueprint $table) {
        $table->id();
        $table->string('class_name', 100);
        $table->text('description')->nullable();
        $table->foreignId('trainer_id')->constrained('trainers')->onDelete('cascade');
        $table->integer('capacity');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fitness_classes');
    }
};
