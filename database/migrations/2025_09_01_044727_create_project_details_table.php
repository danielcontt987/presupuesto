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
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('task_name');
            $table->text('task_description')->nullable();
            $table->text('img')->nullable();
            $table->date('due_date')->nullable();
            $table->text('assigned_to')->nullable();
            $table->enum('priority', ['low', 'medium', 'higth'])->default('low');
            $table->integer('project_colums_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_details');
    }
};
