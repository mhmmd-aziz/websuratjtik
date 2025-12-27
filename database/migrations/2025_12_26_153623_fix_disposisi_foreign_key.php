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
    Schema::table('disposisi_surat', function (Blueprint $table) {
        // 1. Hapus FK lama yang salah
        $table->dropForeign(['surat_id']); 

        
        $table->foreign('surat_id')
              ->references('id')
              ->on('surats')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposisi_surat', function (Blueprint $table) {
            //
        });
    }
};
