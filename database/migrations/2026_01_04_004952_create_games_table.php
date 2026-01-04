<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title')->index();
            $table->text('synopsis')->nullable();
            $table->date('release_date')->nullable();
            $table->unsignedInteger('playtime_hours')->nullable();
            $table->boolean('is_active')->default(true)->index();

            $table->foreignId('publisher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('genre_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('developer_id')->nullable()->constrained()->nullOnDelete();

            // uploader/owner
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
