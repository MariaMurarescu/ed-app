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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class, 'user_id');
            $table->string('title', 1000);
            $table->tinyInteger('status');
            $table->string('slug', 1000);
            $table->text('description')->nullable();
            $table->text('aim')->nullable();
            $table->string('keywords', 200)->nullable();
            $table->string('level', 100)->nullable();
            $table->string('image', 255)->nullable(); //image, audio and video will be stored in the file system
            $table->string('audio')->nullable(); //in the database, it will be stored only the path
            $table->string('video')->nullable();
            $table->timestamps();
            $table->timestamp('expire_date')->nullable();
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
