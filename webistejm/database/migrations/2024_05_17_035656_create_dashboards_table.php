<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeksi', function (Blueprint $table) {
            $table->id('id_inspeksi');
            $table->integer('jumlah_pothole');
            $table->date('tanggal_inspeksi');
            $table->string('video_url');
            $table->string('area');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboards');
        Schema::dropIfExists('data_hasil_deteksi');
        Schema::dropIfExists('inspeksi');
    }
}
