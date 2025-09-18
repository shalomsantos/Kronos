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
        Schema::create('bz_plat_item_subitem_forms', function (Blueprint $table) {
            // columns
            $table->id();
            $table->foreignId('bzero_id')->constrained();
            $table->foreignId('plataforma_id')->constrained();

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('itens');
            $table->unsignedBigInteger('subitem_id');
            $table->foreign('subitem_id')->references('id')->on('subitens');
            $table->unsignedBigInteger('fornecedor_id');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');

            $table->unsignedDecimal('vl_unit_cot');
            $table->unsignedInteger('qt_unid_cot');
            $table->unsignedInteger('multip_cot');

            $table->unsignedDecimal('vl_unit_apr');
            $table->unsignedInteger('qt_unid_apr');
            $table->unsignedInteger('multip_apr');

            $table->unsignedDecimal('vl_executado');

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
        Schema::dropIfExists('bz_plat_item_subitem_forms');
    }
};
