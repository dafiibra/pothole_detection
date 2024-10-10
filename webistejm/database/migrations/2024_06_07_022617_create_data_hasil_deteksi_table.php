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
        Schema::create('data_hasil_deteksi', function (Blueprint $table) {
            $table->string('id_deteksi')->primary();
            $table->string('image_url');
            $table->string('latlong');
            $table->enum('is_valid', ['requested', 'approved', 'rejected'])->default('requested');
            $table->string('area');
            $table->string('validated_by')->nullable();
            $table->string('validated_timestamp')->nullable();
            $table->string('id_inspeksi');
            $table->integer('repair_progress')->default(0);
            $table->string('fifty_pct_image_url')->nullable();
            $table->string('fifty_pct_update_timestamp')->nullable();
            $table->string('onehud_pct_image_url')->nullable();
            $table->string('onehud_pct_update_timestamp')->nullable();
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
        Schema::dropIfExists('data_hasil_deteksi');
    }
};

