<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->float('price');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('subcategory_id');
            $table->string('thumbnail');
            $table->timestamps();
//            $table->foreign('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
//            $table->foreign('subcategory_id')->constrained('subcategories')->onDelete('cascade')->onUpdate('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
