<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Artist::class);
            $table->text('spotify_id')->nullable();
            $table->string('name');
            $table->timestamp('released_at');
            $table->unsignedTinyInteger('type');
            $table->json('tracks')->nullable();
            $table->json('external_urls')->nullable();
            $table->text('cover')->nullable();
            $table->timestamps();
        });

        Schema::create('library_has_albums', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Library::class);
            $table->foreignIdFor(\App\Models\Album::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_has_albums');

        Schema::dropIfExists('albums');
    }
};
