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
        Schema::create('fragrances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->constrained()->onDelete('restrict')->onUpdate('cascade');
            $table->foreignId('collection_id')->nullable()->constrained()->onDelete('set null')->onUpdate('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('image_url', 500)->nullable();
            $table->integer('stock')->default(0);
            $table->enum('concentration', ['EDT', 'EDP', 'Parfum', 'Elixir']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fragrances');
    }
};
