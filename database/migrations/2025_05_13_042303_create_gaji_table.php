<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gaji', function (Blueprint $table) {
            $table->id(); // bigint
            $table->foreignId('karyawan_id')->constrained('karyawan')->onDelete('cascade'); // bigint, NN
            $table->tinyInteger('bulan'); // tinyint, NN
            $table->year('tahun'); // year, NN
            $table->integer('total_hadir')->default(0); // int, NN
            $table->integer('total_izin')->default(0); // int, NN
            $table->integer('total_sakit')->default(0); // int, NN
            $table->integer('total_tanpa_keterangan')->default(0); // int, NN
            $table->decimal('gaji_pokok', 10, 2); // decimal(10,2), NN
            $table->decimal('potongan', 10, 2)->default(0); // decimal(10,2), NN
            $table->decimal('gaji_bersih', 10, 2); // decimal(10,2), NN
            $table->text('keterangan_gaji')->nullable(); // text
            $table->date('tanggal_pembayaran')->nullable();
            $table->timestamps();

            $table->unique(['karyawan_id', 'bulan', 'tahun']); // Gaji unik per karyawan per bulan per tahun
        });
    }
    // ... down method
};