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
        Schema::create('cash_cuts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('salebox_id');
            $table->decimal('real_mount', 10, 2);
            $table->decimal('current_mount', 10, 2);
            $table->decimal('difference', 10, 2);
            $table->decimal('little_box', 10, 2);
            $table->text('observations')->nullable();
            $table->dateTime('date_opening');
            $table->dateTime('date_cute')->nullable();
            $table->string('folio');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_cuts');
    }
};
