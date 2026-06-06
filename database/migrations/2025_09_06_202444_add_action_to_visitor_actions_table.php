<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_actions', function (Blueprint $table) {
            $table->text('action')->after('visitor_id'); // use text for long actions
        });
    }

    public function down(): void
    {
        Schema::table('visitor_actions', function (Blueprint $table) {
            $table->dropColumn('action');
        });
    }
};
