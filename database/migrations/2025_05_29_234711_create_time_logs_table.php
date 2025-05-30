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
        Schema::create('time_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->text('description')->nullable();
            $table->decimal('hours', 5, 2)->default(0);
            $table->json('tags')->nullable(); // For bonus: billable/non-billable
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::table('time_logs', function (Blueprint $table) {
            $table->dropForeign('time_logs_project_id_foreign');
            $table->dropIfExists();
        });
    }
};
