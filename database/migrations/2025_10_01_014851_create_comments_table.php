<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade'); // untuk replies
            $table->string('author_name');
            $table->string('author_email');
            $table->text('content');
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_author_reply')->default(false);
            $table->timestamps();

            $table->index('article_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};