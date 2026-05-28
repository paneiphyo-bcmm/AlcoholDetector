// database/migrations/2024_01_01_000005_create_measurement_records_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('measurement_records', function (Blueprint $table) {
            $table->unsignedBigInteger('record_id')->autoIncrement()->primary();
            $table->char('device_id', 20);
            $table->char('location_id', 10);
            $table->char('user_id', 10)->nullable();
            $table->dateTime('measurement_time');
            $table->decimal('alcohol_level', 4, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('device_id')->references('device_id')->on('devices');
            $table->foreign('location_id')->references('location_id')->on('locations');
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('measurement_records');
    }
};