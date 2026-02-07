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
    Schema::create('queues', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        // Hubungkan ke absensi hari itu
        $table->foreignId('attendance_id')->constrained()->onDelete('cascade');
        $table->integer('queue_number'); // Urutan antrian (1, 2, 3...)
        $table->enum('status', ['menunggu', 'dipanggil', 'sedang_antar', 'selesai'])->default('menunggu');
        $table->dateTime('called_at')->nullable(); // Kapan dipanggil
        $table->dateTime('finished_at')->nullable(); // Kapan selesai
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};
