<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitialMigration extends Migration
{
    public function up()
    {
        Schema::create('t_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('src_id', 30)->unique();
            $table->string('src_name');
            $table->string('src_api_token', 520)->unique()->nullable()->default(null);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('t_run', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('src_id', 30)->unique();
            $table->string('category_id');
            $table->unsignedInteger('personal_best');
            $table->date('run_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('t_user');
        });

        Schema::create('t_vote', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->unique();
            $table->enum('v_timing_method_a', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_timing_method_b', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_timing_method_c', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_timing_method_d', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_hide_timings', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->string('custom_run_url')->nullable();
            $table->string('comment', 1000)->nullable();
            $table->enum('state', ['Pending', 'Verified', 'Rejected', 'Auto-Verified']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('t_user');
        });

        Schema::create('h_verification', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vote_id');
            $table->unsignedBigInteger('user_id');
            $table->enum('state', ['Pending', 'Verified', 'Rejected', 'Auto-Verified']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('t_user');
            $table->foreign('vote_id')->references('id')->on('t_vote');
        });

        Schema::create('h_vote', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vote_id');
            $table->enum('v_timing_method_a', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_timing_method_b', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_timing_method_c', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_timing_method_d', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->enum('v_hide_timings', ['No Vote', 'Yes', 'No'])->default('No Vote');
            $table->string('custom_run_url')->nullable();
            $table->string('comment', 1000)->nullable();
            $table->timestamps();

            $table->foreign('vote_id')->references('id')->on('t_vote');
        });
    }

    public function down()
    {
        //
    }
}
