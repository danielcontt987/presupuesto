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
        Schema::create('project_colums', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('project_detail_id');
            $table->string('name');
            $table->enum('status', ['to_do', 'pending', 'in_progress', 'in_review', 'done'])->default('to_do');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_colums');
    }
};
