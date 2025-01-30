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
        //
        Schema::table('penilaian', function (Blueprint $table) {
            // Ubah nama kolom crips_id menjadi kriteria_id
            $table->renameColumn('crips_id', 'kriteria_id');
        });
        Schema::table('penilaian', function (Blueprint $table) {


            // Tambahkan kolom nilai setelah kriteria_id
            $table->integer('nilai')->after('kriteria_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('penilaian', function (Blueprint $table) {
            // Ubah nama kolom kriteria_id menjadi crips_id
            $table->renameColumn('kriteria_id', 'crips_id');
        });
        Schema::table('penilaian', function (Blueprint $table) {
            // Hapus kolom nilai
            $table->dropColumn('nilai');
        });
    }
};
