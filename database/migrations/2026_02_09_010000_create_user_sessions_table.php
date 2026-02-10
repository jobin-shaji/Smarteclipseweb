<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbcUserSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abc_user_sessions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index();
            $table->string('username', 150);
            $table->string('role', 50)->index();
            $table->string('session_id', 191)->unique();

            // Login details
            $table->timestamp('logged_in_at')->useCurrent()->index();
            $table->string('login_ip', 45)->nullable();
            $table->text('login_user_agent')->nullable();
            $table->string('login_platform', 100)->nullable();
            $table->string('login_office', 100)->nullable();

            // Logout details
            $table->timestamp('logged_out_at')->nullable()->index();
            $table->enum('logout_type', ['manual','timeout','forced','session_expired'])->nullable();

            // Calculated and state
            $table->integer('duration_minutes')->nullable();
            $table->boolean('is_active')->default(true)->index();

            $table->timestamps();

            $table->index(['user_id', 'logged_in_at']);
            $table->index(['is_active', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('abc_user_sessions');
    }
}
