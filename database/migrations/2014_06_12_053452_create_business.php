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
        Schema::create('business', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('name');
            $table->string('pin');
            $table->string('services');
            $table->string('street');
            $table->string('ext');
            $table->string('int')->nullable();
            $table->unsignedBigInteger('colony_id');
            $table->foreign('colony_id')->references('id')->on('colonies');
            $table->string('telephone1');
            $table->string('telephone2');
            $table->string('whatsapp');
            $table->string('website')->nullable();
            $table->string('facebook');
            $table->string('lat')->nullable();
            $table->string('log')->nullable();
            $table->string('fiscal_rfc')->nullable();
            $table->string('fiscal_corporative_name')->nullable();
            $table->string('fiscal_street')->nullable();
            $table->string('fiscal_ext')->nullable();
            $table->string('fiscal_int')->nullable();
            $table->unsignedBigInteger('fiscal_colony_id');
            $table->foreign('fiscal_colony_id')->references('id')->on('colonies');
            $table->string('timezone')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business');
    }
};
