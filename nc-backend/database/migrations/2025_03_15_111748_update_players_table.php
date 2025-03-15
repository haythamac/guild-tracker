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
        Schema::table('players', function (Blueprint $table) {
            // Add new columns
            $table->integer('power')->nullable(); // Make sure power is an integer if needed
            $table->string('power_screenshot_path')->nullable();
            $table->boolean('power_is_processed')->default(false);
            $table->index('ign'); // Adding an index for 'ign'

            // Remove old columns
            $table->dropColumn(['screenshot_path', 'processed_data', 'is_processed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            // Re-add the old columns in case of rollback
            $table->string('screenshot_path')->nullable();
            $table->json('processed_data')->nullable();
            $table->boolean('is_processed')->default(false);

            // Remove newly added columns
            $table->dropColumn(['power_screenshot_path', 'power_is_processed']);
            $table->dropIndex(['ign']); // Removing the index on rollback
        });
    }
};
