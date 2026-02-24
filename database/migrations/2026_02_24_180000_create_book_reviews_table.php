<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->string('member_id');
            $table->unsignedBigInteger('buku_id');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('review')->nullable();
            $table->timestamps();

            $table->foreign('buku_id')->references('id')->on('buku')->onDelete('cascade');
            $table->unique(['member_id', 'buku_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
};
