<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStats extends Migration
{
  public function up()
  {
    Schema::create('t_category', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('src_id', 10)->unique();
      $table->string('src_name', 100);
      $table->string('src_game_id', 10);
      $table->string('src_game_name', 100);
      $table->timestamps();
    });

    Schema::create('t_run', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('src_id', 10)->unique();
      $table->unsignedBigInteger('fk_t_vote');
      $table->unsignedBigInteger('fk_t_category');
      $table->unsignedInteger('personal_best');
      $table->date('run_date');
      $table->timestamps();
      $table->foreign('fk_t_vote')->references('id')->on('t_vote');
      $table->foreign('fk_t_category')->references('id')->on('t_category');
    });
  }

  public function down()
  {
    Schema::drop('t_run');
    Schema::drop('t_category');
  }
}
