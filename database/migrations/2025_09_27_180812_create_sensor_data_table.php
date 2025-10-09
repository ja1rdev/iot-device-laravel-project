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
        Schema::create('sensor_data', function (Blueprint $t) {
            $t->id();
            $t->foreignId('id_sensor')->constrained('sensors');
            $t->foreignId('id_station')->constrained('stations');
            $t->float('temp_value')->nullable();
            $t->float('humidity')->nullable();
            $t->boolean('status')->default(true);
            $t->timestamps();
            $t->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
