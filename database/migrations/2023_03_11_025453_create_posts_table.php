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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('caption');
            $table->string('image')->nullable();
            $table->string('user_id');
            $table->string('likes')->default(0);
            $table->string('comments')->default(0);
            $table->string('shares')->default(0);
            $table->string('views')->default(0);
            $table->string('status')->default('active');
            $table->string('type')->default('image');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
