// database/migrations/2024_01_01_000004_create_devices_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->char('device_id', 20)->primary();
            $table->char('location_id', 10);
            $table->string('device_name', 100);
            $table->string('serial_number', 50)->nullable();
            $table->date('installation_date')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('location_id')->on('locations');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};