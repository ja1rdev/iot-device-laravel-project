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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('code')->unique()->nullable();
            $table->string('abbrev', 10)->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->foreign('id_department')
            ->constrained('departments')
            ->cascadeOnUpdate()
            ->cascadeOnDelete();
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
            $table->timestamp('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
