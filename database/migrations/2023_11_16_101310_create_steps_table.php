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
        Schema::create('steps', function (Blueprint $table) {
            $table->id();
            // レシピテーブルとの外部キー制約
            $table->unsignedBigInteger('recipe_id')->index()->comment('レシピID');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->text('description')->comment('作り方の説明');
            $table->integer('order')->comment('作り方の順番');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('steps');
    }
};
