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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('folio');
            $table->integer('client_id');
            $table->integer('user_id');
            $table->integer('salebox_id');
            $table->integer('cashcut_id');
            $table->enum('status',['Finalizado','Cancelado', 'Pendiente']);
            $table->enum('status_ticket',['Vigente','Cancelado']);
            $table->text('json_concept');
            $table->dateTime('saledate')->nullable();
            $table->double('total');
            $table->double('subtotal');
            $table->double('iva');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
