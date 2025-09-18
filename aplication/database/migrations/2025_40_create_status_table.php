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
        Schema::create('status', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->unsignedBigInteger('pai_id')->nullable();
            $table->foreign('pai_id')->references('id')->on('status');
            $table->unsignedBigInteger('prox_id')->nullable();
            $table->foreign('prox_id')->references('id')->on('status');
            // stamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
