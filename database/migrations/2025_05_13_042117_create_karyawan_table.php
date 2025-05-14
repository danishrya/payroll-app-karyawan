<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id(); // bigint, unsigned, auto_increment, primary
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // bigint, NN
            $table->string('nik', 20)->unique()->nullable(); // VARCHAR(20)
            $table->text('alamat')->nullable();
            $table->string('no_telepon', 15)->nullable();
            $table->string('posisi', 100); // NN
            $table->date('tanggal_masuk'); // NN
            $table->decimal('gaji_pokok', 10, 2); // NN
            $table->timestamps();
        });
    }
    // ... down method
};