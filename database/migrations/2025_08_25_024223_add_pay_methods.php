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
        Schema::table('sales', function (Blueprint $table) {
            $table->double('cash')->after('saledate')->default(0);
            $table->double('transfer')->after('cash')->default(0);
            $table->double('card')->after('transfer')->default(0);
            $table->double('check')->after('card')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->dropColumn(['cash', 'transfer', 'card', 'check']);
        });
    }
};
