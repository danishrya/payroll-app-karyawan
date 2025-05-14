<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id(); // bigint
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade'); // bigint, NN
            $table->date('tanggal'); // NN
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'tanpa keterangan'])->default('tanpa keterangan'); // NN
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['karyawan_id', 'tanggal']); // Seorang karyawan hanya bisa absen sekali sehari
        });
    }
    // ... down method
};