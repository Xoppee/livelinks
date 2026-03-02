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
        Schema::create('link_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('link_id')->constrained('tbl_links', 'id_link');
            $table->string('streamer_name');
            $table->string('username');
            $table->string('link_url');
            $table->string('platform');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('link_logs');
    }
};
