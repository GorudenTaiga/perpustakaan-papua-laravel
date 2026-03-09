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
        // Fill any existing nulls first, then set default
        \DB::statement('UPDATE pinjaman SET total_price = 0 WHERE total_price IS NULL');

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->integer('total_price')->default(0)->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('pinjaman', function (Blueprint $table) {
            $table->integer('total_price')->nullable(false)->change();
        });
    }
};
