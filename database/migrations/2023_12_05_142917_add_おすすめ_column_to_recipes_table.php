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
        Schema::table('recipes', function (Blueprint $table) {
            $table->boolean('おすすめ')->after('name')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */

        public function down()
        {
            Schema::table('recipes', function (Blueprint $table) {
                $table->dropColumn('おすすめ');
            });
        }
};
