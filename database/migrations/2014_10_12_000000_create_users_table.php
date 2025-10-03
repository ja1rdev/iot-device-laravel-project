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
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('username', 100);
            $table->string('role', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone', 20);
            $table->boolean('status')->default(true);
            $table->unsignedBigInteger('city_id'); 
                   $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
$table->id();
$table->id();
$table->string('name');
$table->string('code')->unique();
$table->string('type');
$table->string('unit_measurement');
$table->decimal('min_value', 10, 2);
$table->decimal('max_value', 10, 2);
$table->decimal('current_value', 10, 2)->nullable();
$table->boolean('status')->default(true);

$table->unsignedBigInteger('device_id');
$table->foreign('device_id')->references('id')->on('devices')
      ->cascadeOnUpdate()
      ->cascadeOnDelete();

$table->timestamps();
$table->softDeletes();