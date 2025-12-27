<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('surats', function (Blueprint $table) {
        // Tambah kolom 'sifat_surat' setelah perihal, default-nya 'biasa'
        $table->string('sifat_surat')->default('biasa')->after('perihal_surat');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surats', function (Blueprint $table) {
            //
        });
    }
};
