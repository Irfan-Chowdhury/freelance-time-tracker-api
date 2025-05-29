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
        Schema::create('vaccination_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vaccine_center_id')->index();
            $table->date('scheduled_date')->index();
            $table->integer('users_count')->default(0);
            $table->timestamps();

            $table->foreign('vaccine_center_id')->references('id')->on('vaccine_centers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination_schedules', function (Blueprint $table) {
            $table->dropForeign('vaccination_schedules_vaccine_center_id_foreign');
            $table->dropIndex(['vaccine_center_id']);
            $table->dropIndex(['scheduled_date']);
            $table->dropIfExists();
        });
    }
};
