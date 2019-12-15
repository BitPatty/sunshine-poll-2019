<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitialMigration extends Migration
{
  public function up()
  {
    Schema::create('t_vote', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('src_id', 10)->unique();
      $table->string('src_name', 80)->unique();

      $table->boolean('has_voted')->default(false);
      $table->boolean('has_src_run')->default(false);
      $table->boolean('is_verified')->default(false);
      $table->string('custom_run_url', 100)->nullable();

      $table->enum('v_hide_timings', ['Indifferent', 'Yes', 'No'])->default('Indifferent');
      $table->enum('v_option_a', ['Indifferent', 'Yes', 'No'])->default('Indifferent');
      $table->enum('v_option_b', ['Indifferent', 'Yes', 'No'])->default('Indifferent');
      $table->enum('v_option_c', ['Indifferent', 'Yes', 'No'])->default('Indifferent');
      $table->enum('v_option_d', ['Indifferent', 'Yes', 'No'])->default('Indifferent');
      $table->enum('v_option_e', ['Indifferent', 'Yes', 'No'])->default('Indifferent');
      $table->text('comment')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('t_vote');
  }
}
