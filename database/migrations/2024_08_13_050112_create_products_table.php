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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->string('folio_personality')->nullable();
            $table->string('name');
            $table->string('barcode');
            $table->string('descrition');
            $table->boolean('is_service')->default(0);
            $table->decimal('price_shop')->default(0);
            $table->decimal('price_s_shop')->default(0);
            $table->decimal('price_sale')->default(0);
            $table->decimal('price_s_sale')->default(0);
            $table->decimal('iva')->default(0);
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
