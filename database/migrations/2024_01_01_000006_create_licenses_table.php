// database/migrations/2024_01_01_000006_create_licenses_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->char('license_id', 20)->primary();
            $table->char('company_id', 10);
            $table->unsignedInteger('contract_count')->default(0);
            $table->unsignedInteger('usage_count')->default(0);
            $table->timestamps();

            $table->foreign('company_id')->references('company_id')->on('companies');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};