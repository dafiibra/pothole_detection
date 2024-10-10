<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('log_activity', function (Blueprint $table) {
            $table->id('id_activity');
            $table->timestamp('activity_timestamp')->nullable();
            $table->string('activity_name');
            $table->string('username');
            $table->string('ip_address');
            $table->timestamp('login_time')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('log_activity');
    }
};
