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
        Schema::create('bzero_plataforma_item_subitem_fornecedor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bzero_id')->constrained();
            $table->foreignId('plataforma_id')->constrained();

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('itens');
            $table->unsignedBigInteger('subitem_id');
            $table->foreign('subitem_id')->references('id')->on('subitens');
            $table->unsignedBigInteger('fornecedor_id')->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');

            $table->unsignedDecimal('vl_unit_cot')->default(0);
            $table->unsignedInteger('qt_unid_cot')->nullable(false)->default(1);
            $table->unsignedInteger('multip_cot')->nullable(false)->default(1);

            $table->unsignedDecimal('vl_unit_apr')->default(0);
            $table->unsignedInteger('qt_unid_apr')->nullable(false)->default(1);
            $table->unsignedInteger('multip_apr')->nullable(false)->default(1);

            $table->unsignedDecimal('vl_executado')->default(0);

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
        Schema::dropIfExists('bzero_plataforma_item_subitem_fornecedor');
    }
};
