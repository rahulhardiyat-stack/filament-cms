<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppks_reports', function (Blueprint $table) {
            $table->text('evidence_paths')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ppks_reports', function (Blueprint $table) {
            $table->dropColumn('evidence_paths');
        });
    }
};
