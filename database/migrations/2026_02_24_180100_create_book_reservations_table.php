<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_reservations', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->unsignedBigInteger('buku_id');
            $table->enum('status', ['waiting', 'available', 'cancelled', 'fulfilled'])->default('waiting');
            $table->timestamp('reserved_at')->useCurrent();
            $table->timestamp('notified_at')->nullable();
            $table->timestamps();

            $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reservations');
    }
};
