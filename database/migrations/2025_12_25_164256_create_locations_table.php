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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['workshop', 'tuv', 'tire_dealer'])->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('street')->nullable();
            $table->string('house_number')->nullable();
            $table->string('postal_code')->nullable()->index();
            $table->string('city')->nullable()->index();
            $table->string('state')->nullable()->index();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->json('opening_hours')->nullable();
            $table->string('osm_id')->unique();
            $table->string('osm_type')->nullable(); // node, way, relation
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();

            // Indexes for search
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
