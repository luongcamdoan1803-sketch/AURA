<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('category_id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('style', ['gio', 'bo', 'hop'])->nullable();
            $table->decimal('price', 12, 2);
            $table->string('image')->default('default.jpg');
            $table->text('description')->nullable();
            $table->float('rating')->default(5.0);
            $table->timestamps();

            // Ràng buộc Khóa ngoại
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};