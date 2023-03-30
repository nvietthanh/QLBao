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
        Schema::create('account_notice', function (Blueprint $table) {
            $table->foreignId('account_id')->constrained('accounts')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('notice_id')->constrained('notices')->onUpdate('cascade')->onDelete('cascade');
            $table->dateTime('read_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_notice');
    }
};
