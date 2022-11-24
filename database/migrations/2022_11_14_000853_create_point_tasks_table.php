<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('description');
            $table->decimal('point', 8, 0)->comment('積分異動');
            $table->boolean('is_disabled')->default(1);
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
        Schema::dropIfExists('point_tasks');
    }
}
