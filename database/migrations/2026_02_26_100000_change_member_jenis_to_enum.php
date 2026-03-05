<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop enum type if exists (PostgreSQL creates custom enum types)
        if (DB::getDriverName() === 'pgsql') {
            DB::statement("ALTER TABLE member ALTER COLUMN jenis DROP DEFAULT");
            DB::statement("ALTER TABLE member ALTER COLUMN jenis TYPE VARCHAR(255)");
            DB::statement("DROP TYPE IF EXISTS member_jenis_check");
        }

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
