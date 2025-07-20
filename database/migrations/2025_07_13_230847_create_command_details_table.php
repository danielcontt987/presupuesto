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
        Schema::create('command_details', function (Blueprint $table) {
            $table->id();
            $table->integer('command_id');
            $table->integer('product_id');
            $table->integer('quantity')->default(1); // Default quantity is 1
            $table->decimal('price', 10, 2); // Price of the product at the time of the command
            $table->decimal('total', 10, 2); // Total price for this detail (quantity * price)
            $table->string('status')->default('pending'); // Status of the command detail, e.g., pending, completed, cancelled
            $table->text('notes')->nullable(); // Optional notes for the command detail
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command_details');
    }
};
