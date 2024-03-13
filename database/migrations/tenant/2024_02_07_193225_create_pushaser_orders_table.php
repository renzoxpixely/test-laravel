<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pushaser_order', function (Blueprint $table) {
            $table->id();
            // Agrega las columnas id_sale_document, id_sales, id_order_sale_document si es necesario
            $table->unsignedBigInteger('id_sale_document');
            $table->unsignedBigInteger('id_sales');
            $table->unsignedBigInteger('id_order_sale_document');

            // Add missing columns for inheritance
            $table->integer('sale');
            $table->integer('sale_document');
            $table->integer('order_sale_document');

            $table->timestamps();
        });
        // Ejecuta SQL puro para agregar herencia
        DB::statement('ALTER TABLE pushaser_order INHERIT sale_document;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pushaser_orders');
    }
};
