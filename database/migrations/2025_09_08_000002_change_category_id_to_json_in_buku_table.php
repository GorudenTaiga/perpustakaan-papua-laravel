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
        Schema::table('buku', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->json('category_id')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories');
        });
    }
};