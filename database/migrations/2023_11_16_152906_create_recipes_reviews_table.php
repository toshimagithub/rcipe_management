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
        Schema::create('recipes_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id')->index()->comment('レシピID');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->index()->comment('ユーザーID');
            $table->integer('star')->default(0)->comment('星');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes_reviews');
    }
};
