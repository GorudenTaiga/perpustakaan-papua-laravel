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
        Schema::dropIfExists('buku');
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('judul');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->integer('year');
            $table->integer('stock');
            $table->decimal('price_per_day');
            $table->integer('max_days')->nullable();
            $table->text('deskripsi');
            $table->string('slug');
            $table->foreignId('category_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};