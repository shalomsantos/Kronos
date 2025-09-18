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
            $table->string('descricao');
            $table->string('extensao');
            $table->string('path');
            $table->unsignedBigInteger('bz_plat_item_subitem_form_id');
            $table->foreign('bz_plat_item_subitem_form_id')->references('id')->on('bz_plat_item_subitem_forms');
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
