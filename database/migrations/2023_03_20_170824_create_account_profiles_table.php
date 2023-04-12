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
        Schema::create('account_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('male')->default(0)->comment('0:Nam, 1:Nữ, 2:Khác');
            $table->date('date_of_birth')->nullable();
            $table->string('phone')->nullable();      
            $table->text('image')->nullable();
            $table->string('description')->nullable();
            $table->longText('remark')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_profiles');
    }
};
