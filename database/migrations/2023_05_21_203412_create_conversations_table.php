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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_send_id');
            $table->unsignedBigInteger('account_receive_id');
            $table->longText('last_message')->nullable();
            $table->unsignedBigInteger('last_account_id')->nullable();
            $table->datetime('last_message_time')->nullable();
            $table->timestamps();

            $table->foreign('account_send_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreign('account_receive_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};
