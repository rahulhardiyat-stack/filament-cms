<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 30)->unique();
            $table->string('name');
            $table->string('program_studi');
            $table->string('birth_date_password');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ppks_reports', function (Blueprint $table) {
            $table->id();
            $table->uuid('reference')->unique();
            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->string('reporter_role', 20);
            $table->date('incident_date');
            $table->text('location');
            $table->text('reported_person')->nullable();
            $table->text('chronology');
            $table->text('contact');
            $table->text('support_needed')->nullable();
            $table->timestamp('consented_at');
            $table->string('status', 20)->default('submitted');
            $table->text('response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppks_reports');
        Schema::dropIfExists('students');
    }
};
