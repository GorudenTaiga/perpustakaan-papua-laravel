<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->enum('tier', ['reguler', 'premium'])->default('reguler')->after('jenis');
            $table->timestamp('tier_expired_at')->nullable()->after('tier');
        });
    }

    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn(['tier', 'tier_expired_at']);
        });
    }
};
