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
        if (!Schema::hasTable('stations')) {
            Schema::create('stations', function (Blueprint $table) {
                $table->id();
                $table->string('name', 100);
                $table->string('code');
                $table->boolean('status')->default(true);
                $table->integer('id_city')->nullable();
                $table->foreign('id_city')
                ->constrained('cities')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                $table->timestamps('created_at');
                $table->timestamps('updated_at');
                $table->timestamp('deleted_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stations');
    }
};
