<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('report', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('period_type')->default('bulanan')->after('title');
            $table->date('period_start')->nullable()->after('period_type');
            $table->date('period_end')->nullable()->after('period_start');
            $table->unsignedBigInteger('generated_by')->nullable()->after('period_end');
            $table->json('data')->nullable()->after('total_returns');
        });
    }

    public function down(): void
    {
        Schema::table('report', function (Blueprint $table) {
            $table->dropColumn(['title', 'period_type', 'period_start', 'period_end', 'generated_by', 'data']);
        });
    }
};
