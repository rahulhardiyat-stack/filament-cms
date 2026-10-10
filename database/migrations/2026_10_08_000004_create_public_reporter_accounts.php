<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_reporters', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->text('name');
            $table->string('password');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        Schema::table('ppks_reports', function (Blueprint $table) {
            $table->foreignId('public_reporter_id')->nullable()->constrained('public_reporters')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ppks_reports', function (Blueprint $table) {
            $table->dropConstrainedForeignId('public_reporter_id');
        });
        Schema::dropIfExists('public_reporters');
    }
};
