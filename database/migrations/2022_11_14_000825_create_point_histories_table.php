<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('point_task_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->decimal('before', 8, 0)->unsigned();
            $table->decimal('change', 8, 0);
            $table->decimal('after', 8, 0)->unsigned();
            $table->string('description');
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('point_histories');
    }
}
