<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ritases', function (Blueprint $table) {
            // Kita ubah 'tujuan' jadi nullable dulu jaga-jaga kalau OCR gagal
            $table->string('tujuan')->nullable()->change(); 
            
            // Kolom baru hasil scan
            $table->string('foto_bukti')->nullable()->after('queue_id'); // Path gambar
            $table->text('lokasi_jemput')->nullable()->after('tujuan');
            $table->text('lokasi_tujuan')->nullable()->after('lokasi_jemput');
            $table->decimal('pendapatan', 15, 2)->nullable()->after('lokasi_tujuan');
        });
    }

    public function down(): void
    {
        Schema::table('ritases', function (Blueprint $table) {
            $table->dropColumn(['foto_bukti', 'lokasi_jemput', 'lokasi_tujuan', 'pendapatan']);
        });
    }
};