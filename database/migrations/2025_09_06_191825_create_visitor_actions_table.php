<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // migration
Schema::create('visitor_actions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('visitor_id')->constrained()->onDelete('cascade'); // This is required!
$table->text('action')->change();
$table->text('url')->change();
    $table->json('details')->nullable();
    $table->timestamps();
});


    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_actions');
    }
};
