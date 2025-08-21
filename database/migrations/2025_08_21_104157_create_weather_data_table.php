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
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('provider');
            $table->decimal('temperature', 5, 2);
            $table->integer('humidity');
            $table->string('description');
            $table->string('icon')->nullable();
            $table->decimal('pressure', 8, 2)->nullable();
            $table->decimal('wind_speed', 5, 2)->nullable();
            $table->timestamp('forecast_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
