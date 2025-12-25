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
        Schema::create('workshop_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->json('specializations')->nullable(); // ["brakes", "tires", "inspection", "oil_change"]
            $table->json('brands_serviced')->nullable(); // ["VW", "Audi", "BMW"]
            $table->json('services')->nullable(); // ["general_repair", "tire_service", "inspection"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshop_details');
    }
};
