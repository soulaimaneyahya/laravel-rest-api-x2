<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('name');
            $table->string('description', 700);
            $table->integer('quantity')->unsigned();
            $table->float('price', 8, 2);
            $table->string(Product::STATUS, '12')->default(Product::UNAVAILABLE_PRODUCT);
            $table->string('image');
            $table->foreignUuid('seller_id')->constrained()->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
