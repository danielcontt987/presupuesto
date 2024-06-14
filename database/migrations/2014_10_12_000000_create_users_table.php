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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('work_number');
            $table->string('name');
            $table->string('lastname');
            $table->string('phone');
            $table->string('img')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('street');
            $table->string('ext');
            $table->string('int')->nullable();
            $table->unsignedBigInteger('colony_id');
            $table->foreign('colony_id')->references('id')->on('colonies');
            $table->string('curp')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('gender')->nullable();
            $table->string('rfc')->nullable();
            $table->string('nss')->nullable();
            $table->boolean('can_edit')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
