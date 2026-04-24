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
        Schema::create('peminjamen', function (Blueprint $table) {
            $table->id();
            // relasi
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('book_id')->constrained('bukus')->cascadeOnDelete();

            // tanggal
            $table->date('tanggal_pinjam');
            $table->date('tanggal_jatuh_tempo');
            $table->date('tanggal_kembali')->nullable();

            // status
            $table->enum('status', ['dipinjam', 'telat', 'dikembalikan'])->default('dipinjam');
            
            // denda
            $table->integer('denda')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamen');
    }
};
