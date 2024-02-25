<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_school_class', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_class_id');
            $table->string('enrollment_code')->unique();
            $table->unsignedInteger('role');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('school_class_id')->references('id')->on('school_classes');
            $table->unique(['user_id', 'school_class_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_school_class');
    }
};