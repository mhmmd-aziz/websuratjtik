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
        // 1. Buat kolomnya dulu (nullable sementara)
        $table->string('kode_tiket', 10)->after('id')->nullable();
    });

    // 2. Isi kode unik untuk data yang SUDAH ADA (biar gak error unique)
    $surats = \DB::table('surats')->get();
    foreach ($surats as $s) {
        \DB::table('surats')->where('id', $s->id)->update([
            'kode_tiket' => strtoupper(\Illuminate\Support\Str::random(6))
        ]);
    }

    // 3. Ubah jadi Unique dan Tidak Boleh Null
    Schema::table('surats', function (Blueprint $table) {
        $table->string('kode_tiket', 10)->nullable(false)->unique()->change();
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
