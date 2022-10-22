<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllLogsTable extends Migration
{
    public function up()
    {
        Schema::create('all_logs', function (Blueprint $table) {
            $table->id();
            $table->text('request');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('all_logs');
    }
}
