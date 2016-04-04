<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('victory_points');
            $table->integer('player_id')->unsigned();
            $table->foreign('player_id')
                ->references('id')->on('players')
                ->onDelete('cascade');
            $table->integer('match_id')->unsigned();
            $table->foreign('match_id')
                ->references('id')->on('matches')
                ->onDelete('cascade');
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
        Schema::drop('scores');
    }
}
