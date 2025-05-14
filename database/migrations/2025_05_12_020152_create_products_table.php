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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->nullable();
            $table->string('name', 150)->nullable();
            $table->string('photo')->nullable();
            $table->integer('category_id', [])->nullable();
            $table->integer('stock')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->timestamps();   
        });

        // Schema::table('products', function (Blueprint $table) {
        //     $table->string('image')->nullable()->after('price'); // Add after whichever column makes sense
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');

        Schema::table('products', function (Blueprint $table) {
            // $table->dropColumn('image');
        });
    }
};
