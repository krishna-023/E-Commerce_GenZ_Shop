<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('Category_Name');          // Category name
            $table->integer('parent_id')->nullable(); // Parent category
            $table->integer('reference_id')->nullable(); // Reference ID (if needed)
            $table->string('slug')->nullable();       // Slug for URLs
            $table->timestamps();                     // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
