<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('address', 255)->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('password', 255)->nullable();
            $table->rememberToken();
            $table->enum('role', ['superadmin', 'admin', 'member']);
            $table->boolean('is_member')->default(0);
            $table->string('profile_photo', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
