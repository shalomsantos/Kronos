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
        Schema::create('plataforma_item_subitem_fornecedor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plataforma_id');
            $table->foreign('plataforma_id')->references('id')->on('plataformas');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('itens');

            $table->unsignedBigInteger('subitem_id');
            $table->foreign('subitem_id')->references('id')->on('subitens');

            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            
            $table->unsignedDecimal('vl_unit_cot')->default(0);
            $table->unsignedTinyInteger('qt_unidade_cot')->default(1);
            $table->unsignedTinyInteger('qt_multip_uni_cot')->default(1);

            $table->unsignedDecimal('vl_unit_apr')->default(0);
            $table->unsignedTinyInteger('qt_unidade_apr')->default(1);
            $table->unsignedTinyInteger('qt_multip_uni_apr')->default(1);
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
        Schema::dropIfExists('plataforma_item_subitem_fornecedor');
    }
};
