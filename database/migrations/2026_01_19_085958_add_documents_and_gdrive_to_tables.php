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
        // Add document field to member table for registration requirements
        Schema::table('member', function (Blueprint $table) {
            $table->string('document_path')->nullable()->after('image');
        });

        // Add Google Drive link and remove rating from buku table
        Schema::table('buku', function (Blueprint $table) {
            $table->string('gdrive_link')->nullable()->after('banner');
            $table->dropColumn('rating');
        });

        // Rename payments table concept - keep structure but repurpose
        // This will be used for fines/denda management instead of payments
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropColumn('document_path');
        });

        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn('gdrive_link');
            $table->double('rating')->default(0.0);
        });
    }
};
