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
        Schema::create('status_historicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bzero_id');
            $table->foreign('bzero_id')->references('id')->on('bzeros');
            $table->unsignedBigInteger('status_antigo_id');
            $table->foreign('status_antigo_id')->references('id')->on('status');
            $table->unsignedBigInteger('status_novo_id');
            $table->foreign('status_novo_id')->references('id')->on('status');
            // stamps
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_historicos');
    }
};
