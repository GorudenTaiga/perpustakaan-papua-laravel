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
            DB::statement("ALTER TABLE payments ALTER COLUMN payment_method DROP DEFAULT");
            DB::statement("ALTER TABLE payments ALTER COLUMN payment_method TYPE VARCHAR(255)");
            DB::statement("DROP TYPE IF EXISTS payments_payment_method_check");
        }

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer', 'qris'])->after('payment_date');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer'])->after('payment_date');
        });
    }
};
