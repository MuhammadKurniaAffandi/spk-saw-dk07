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
            // Mengubah nama kolom 'alamat' menjadi 'jenis_kelamin'
            $table->renameColumn('alamat', 'jenis_kelamin');

            // Mengubah nama kolom 'telepon' menjadi 'tanggal_lahir'
            $table->renameColumn('telepon', 'tanggal_lahir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alternatif', function (Blueprint $table) {
            // Mengembalikan perubahan jika migrasi dibatalkan
            $table->renameColumn('jenis_kelamin', 'alamat');
            $table->renameColumn('tanggal_lahir', 'telepon');
        });
    }
};
