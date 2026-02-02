<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoginLogsTable extends Migration
{
    public function up()
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('username', 150);
            $table->string('role', 50);
            $table->string('ip_address', 45);
            $table->text('user_agent');
            $table->string('platform', 100);
            $table->timestamp('created_at')->useCurrent();

            $table->index('user_id');
            $table->index('role');
            $table->index('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('login_logs');
    }
}
