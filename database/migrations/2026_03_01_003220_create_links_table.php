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
        Schema::create('tbl_links', function (Blueprint $table) {
            $table->id('id_link');
            $table->string('link_url', 90);
            $table->string('username');
            $table->string('message')->nullable(true);
            $table->boolean('is_accept')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_links');
    }
};
