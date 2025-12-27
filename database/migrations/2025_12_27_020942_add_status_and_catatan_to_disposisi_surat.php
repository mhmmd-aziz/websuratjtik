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
        // Default 'pending' artinya baru masuk ke dashboard prodi (belum diapa-apain)
        $table->string('status')->default('pending')->after('prodi_id'); 
        $table->text('catatan')->nullable()->after('status');
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
