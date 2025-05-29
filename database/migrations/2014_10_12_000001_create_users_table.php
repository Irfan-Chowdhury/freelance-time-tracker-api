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
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->string('email')->unique();
            $table->date('date_of_birth');
            $table->string('nid')->unique();
            $table->text('address');
            $table->string('phone');
            $table->enum('vaccine_status', ['Not registered', 'Not scheduled', 'Scheduled', 'Vaccinated'])
                    ->default('Not registered');
            $table->foreignId('vaccine_center_id');
            $table->date('scheduled_date')->index()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('vaccine_center_id')->references('id')->on('vaccine_centers')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_vaccine_center_id_foreign');
            $table->dropIndex(['scheduled_date']);
            $table->dropIfExists();
        });
    }
};
