<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menghapus kolom terkait jual-beli dari tabel pinjaman
     * dan menambah kolom keterangan pada tabel payments untuk denda.
     */
    public function up(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropColumn(['total_price', 'discount', 'final_price']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->text('keterangan')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->integer('total_price')->default(0);
            $table->integer('discount')->nullable();
            $table->integer('final_price')->nullable();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('keterangan');
        });
    }
};
