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
            $table->uuid('uuid')->primary()->unique();
            $table->string('code')->unique();
            $table->string('name');
            // $table->binary('image');
            $table->longText('image')->charset('binary');
            $table->string('price');
            $table->text('description');
            $table->integer('stock');
            $table->integer('sold_out_quantity');
            $table->string('admin_uuid');
            $table->timestamps();
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
