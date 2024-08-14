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
        Schema::create('business_clients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->foreign('business_id')->references('id')->on('business');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('business');
            $table->enum('status', ['active', 'propectus', 'inactive']);
            $table->boolean('iscredit')->default(0);
            $table->enum('unit_time_credit', ['na', 'month', 'days']);
            $table->integer('days_credit')->default(0);
            $table->string('client_number')->nullable();
            $table->decimal('limit_credit')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_clients');
    }
};
