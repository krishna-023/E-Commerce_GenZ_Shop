<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitor_actions', function (Blueprint $table) {
            if (!Schema::hasColumn('visitor_actions', 'url')) {
                $table->text('url')->after('action'); // Use TEXT to avoid "Data too long"
            }
        });
    }

    public function down(): void
    {
        Schema::table('visitor_actions', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
