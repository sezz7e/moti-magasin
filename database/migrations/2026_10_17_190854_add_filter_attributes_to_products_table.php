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
    Schema::table('products', function (Blueprint $table) {
        $table->json('metals')->nullable()->after('stock');
        $table->json('stone_colors')->nullable()->after('metals');
        $table->json('sizes')->nullable()->after('stone_colors');
    });
}

public function down(): void
{
    Schema::table('products', function (Blueprint $table) {
        $table->dropColumn(['metals', 'stone_colors', 'sizes']);
    });
}
};
