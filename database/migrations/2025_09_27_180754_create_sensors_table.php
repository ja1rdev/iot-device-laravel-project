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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('username')->unique();
            $table->string('role');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobile_phone')->nullable();
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities')
                  ->cascadeOnUpdate()
                  ->cascadeOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
