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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->code('code')->nullable();
            $table->string('abbrev', 10)->nullable();
            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')
            ->casacadeOnUpdate()
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
        Schema::dropIfExists('departments');
    }
};
