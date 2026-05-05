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
        Schema::create('anexos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_arquivo');
            $table->text('descricao')->nullable();
            $table->string('extensao');
            $table->string('path');
            $table->unsignedBigInteger('bzero_plataforma_item_subitem_fornecedor_id');
            $table->foreign('bzero_plataforma_item_subitem_fornecedor_id')->references('id')->on('bzero_plataforma_item_subitem_fornecedor');
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
        Schema::dropIfExists('anexos');
    }
};
