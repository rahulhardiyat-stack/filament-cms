<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ppks_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->change();
            $table->string('reporter_type', 20)->default('student')->index();
            $table->text('reporter_name')->nullable();
            $table->string('access_token_hash', 64)->nullable();
        });
    }

    public function down(): void
    {
        // Public reports have no student identity; retain the nullable FK on rollback.
        Schema::table('ppks_reports', function (Blueprint $table) {
            $table->dropColumn(['reporter_type', 'reporter_name', 'access_token_hash']);
        });
    }
};
