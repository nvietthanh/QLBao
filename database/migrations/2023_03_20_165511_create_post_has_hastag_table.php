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
        Schema::create('post_has_hagtag', function (Blueprint $table) {
            $table->unsignedBigInteger('hagtag_id')->nullable();
            $table->unsignedBigInteger('post_id')->nullable();
            $table->dateTime('created_at')->nullable();

            $table->foreign('hagtag_id')->references('id')->on('hagtags')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_has_hagtag');
    }
};
