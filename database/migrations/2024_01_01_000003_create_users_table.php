// database/migrations/2024_01_01_000003_create_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->char('user_id', 10)->primary();
            $table->char('company_id', 10);
            $table->string('user_name', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->char('location_id', 10)->nullable();
            $table->enum('role', ['admin', 'organization', 'private'])->default('private');
            $table->timestamps();

            $table->foreign('company_id')->references('company_id')->on('companies');
            $table->foreign('location_id')->references('location_id')->on('locations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};