<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('candidate_name')->nullable();
            $table->json('skills')->nullable();
            $table->integer('years_experience')->nullable();
            $table->string('education')->nullable();
            $table->string('suggested_role')->nullable();
            $table->longText('raw_text')->nullable();
            $table->json('ai_response')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};