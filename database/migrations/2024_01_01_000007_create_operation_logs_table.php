// database/migrations/2024_01_01_000007_create_operation_logs_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operation_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('log_id')->autoIncrement()->primary();
            $table->char('user_id', 10);
            $table->text('operation_detail');
            $table->timestamp('operation_time')->useCurrent();
            $table->string('ip_address', 45)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operation_logs');
    }
};