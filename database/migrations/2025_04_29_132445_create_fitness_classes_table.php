<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
      Schema::create('fitness_classes', function (Blueprint $table) {
    $table->id();
    $table->string('class_name', 100)->nullable();
    $table->text('description')->nullable();
    $table->integer('capacity')->nullable();
});

    }

    public function down(): void
    {
        Schema::dropIfExists('fitness_classes');
    }
};
