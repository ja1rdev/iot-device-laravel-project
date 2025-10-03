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
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->id();
        
            $table->unsignedBigInteger('sensor_id');
            $table->foreign('sensor_id')->references('id')->on('sensors')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        
            $table->unsignedBigInteger('station_id');
            $table->foreign('station_id')->references('id')->on('stations')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();
        
            $table->float('temp_value')->nullable();
            $table->float('humidity')->nullable();
            $table->boolean('status')->default(true);
        
            $table->timestamps();
            $table->softDeletes();
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
