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
    Schema::create('surats', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pengirim');
        $table->string('perihal_surat');
        $table->text('email');
        $table->string('file_surat')->nullable();

        // pending, terkirim, disposisi, arsip
        $table->enum('status', ['pending','terkirim','disposisi','arsip'])->default('pending');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
