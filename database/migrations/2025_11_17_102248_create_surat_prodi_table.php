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
    Schema::create('surat_prodi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('surat_id')->constrained('surats')->onDelete('cascade');
        $table->enum('prodi', ['TI','TRKJ','TRMM']);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_prodi');
    }
};
