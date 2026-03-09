<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->index('users_id');
            $table->index('membership_number');
        });

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->index('member_id');
            $table->index('buku_id');
            $table->index('status');
            $table->index(['status', 'created_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->index('pinjaman_id');
        });

        Schema::table('book_reviews', function (Blueprint $table) {
            $table->index('member_id');
            $table->index('buku_id');
            $table->index(['buku_id', 'member_id']);
        });

        Schema::table('book_reservations', function (Blueprint $table) {
            $table->index('member_id');
            $table->index('buku_id');
            $table->index(['member_id', 'status']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->index('member_id');
            $table->index(['member_id', 'read_at']);
            $table->index(['member_id', 'created_at']);
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->index('member_id');
            $table->index('buku_id');
            $table->index(['member_id', 'buku_id']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index('member_id');
        });
    }

    public function down(): void
    {
        Schema::table('member', function (Blueprint $table) {
            $table->dropIndex(['users_id']);
            $table->dropIndex(['membership_number']);
        });

        Schema::table('pinjaman', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
            $table->dropIndex(['buku_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['status', 'created_at']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex(['pinjaman_id']);
        });

        Schema::table('book_reviews', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
            $table->dropIndex(['buku_id']);
            $table->dropIndex(['buku_id', 'member_id']);
        });

        Schema::table('book_reservations', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
            $table->dropIndex(['buku_id']);
            $table->dropIndex(['member_id', 'status']);
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
            $table->dropIndex(['member_id', 'read_at']);
            $table->dropIndex(['member_id', 'created_at']);
        });

        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
            $table->dropIndex(['buku_id']);
            $table->dropIndex(['member_id', 'buku_id']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex(['member_id']);
        });
    }
};
