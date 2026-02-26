<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });

        Schema::table('member', function (Blueprint $table) {
            $table->enum('jenis', ['Pelajar', 'Mahasiswa', 'Guru', 'Dosen', 'Umum'])->nullable()->after('valid_date');
        });
    }

    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn('jenis');
        });

        Schema::table('member', function (Blueprint $table) {
            $table->string('jenis')->nullable()->after('valid_date');
        });
    }
};
