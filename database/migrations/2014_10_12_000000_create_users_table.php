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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('tax_id')->unique();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->timestamp('activated_at')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->schemalessAttributes('extra_attributes');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
