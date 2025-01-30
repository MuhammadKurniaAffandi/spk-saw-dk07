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
        Schema::table('alternatif', function (Blueprint $table) {
            // Mengubah tipe data kolom 'jenis_kelamin' menjadi ENUM
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->change();
            // Mengubah tipe data kolom 'tanggal_lahir' menjadi DATE
            $table->date('tanggal_lahir')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alternatif', function (Blueprint $table) {
            $table->string('jenis_kelamin')->change(); // Kembali ke tipe string
            $table->string('tanggal_lahir')->change(); // Kembali ke tipe string
        });
    }
};
