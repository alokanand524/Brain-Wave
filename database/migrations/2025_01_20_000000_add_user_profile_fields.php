<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('mobile')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('is_email_verified')->default(false);
            $table->text('refresh_token')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->timestamp('email_verification_expiry')->nullable();
            $table->string('magic_login_token')->nullable();
            $table->timestamp('magic_login_expires_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mobile', 'date_of_birth', 'gender', 'is_email_verified',
                'refresh_token', 'email_verification_token', 'email_verification_expiry',
                'magic_login_token', 'magic_login_expires_at'
            ]);
        });
    }
};