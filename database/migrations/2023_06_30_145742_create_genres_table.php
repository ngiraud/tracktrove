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
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description')->nullable();
        });

        Schema::create('model_has_genres', function (Blueprint $table) {
            $table->morphs('model');
            $table->foreignIdFor(\App\Models\Genre::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_genres');
        
        Schema::dropIfExists('genres');
    }
};
