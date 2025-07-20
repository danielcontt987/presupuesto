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
        Schema::create('commands', function (Blueprint $table) {
            $table->id();
            $table->integer('table_id');
            $table->integer('user_id');
            $table->string('status')->default('pending'); // Example status
            $table->decimal('total_amount', 10, 2)->default(0.00); // Example total amount
            $table->text('notes')->nullable(); // Optional notes for the command
            $table->integer('chef_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commands');
    }
};
