<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gchat_users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('fio')->nullable();
            $table->string('hash')->nullable();
            $table->timestamp('last_time')->nullable();
            $table->string('connect')->nullable();
            $table->text('connect_data')->nullable();
            $table->timestamps();
        });

        Schema::create('gchat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('gchat_users')->cascadeOnDelete();
            $table->text('message');
            $table->timestamp('created_at')->nullable();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('gchat_users');
        Schema::dropIfExists('gchat_messages');
    }
};
