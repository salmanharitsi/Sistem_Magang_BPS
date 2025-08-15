<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fungsi_bagian_jurusan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fungsi_bagian_id')->constrained('fungsi_bagian')->onDelete('cascade');
            $table->string('jurusan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fungsi_bagian_jurusan');
    }
};