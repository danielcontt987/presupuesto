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
        Schema::table('business', function (Blueprint $table) {
            $table->string('password')->nullable();
            $table->string('internet')->nullable();
            $table->string('cer')->nullable();
            $table->string('key')->nullable();
            $table->string('tax_regime')->nullable();
            $table->string('cfdi')->default();
            $table->string('folio_business')->default();
            $table->string('long')->nullable();
            $table->enum('type_doc',['ticket', 'document'])->default('document');
            $table->boolean('iva')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business', function (Blueprint $table) {
            $table->dropColumn('password');
            $table->dropColumn('internet');
            $table->dropColumn('cer');
            $table->dropColumn('key');
            $table->dropColumn('tax_regime');
            $table->dropColumn('cfdi');
            $table->dropColumn('folio_business');
            $table->dropColumn('long');
            $table->dropColumn('type_doc');
            $table->dropColumn('iva');
        });
    }
};
