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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment('0: content, 1: image, 2: file');
            $table->longText('content')->nullable();
            $table->string('file')->nullable();
            $table->boolean('status')->default('0');
            $table->unsignedBigInteger('account_send_id');
            $table->unsignedBigInteger('account_receive_id');
            $table->unsignedBigInteger('conversation_id');
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
        Schema::dropIfExists('chat_message');
    }
};
