<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFlags extends Migration
{
    public function up()
    {
        \App\Models\User::create(['src_id' => 'xxxxxxxxxxxxxxxxxx', 'src_name' => 'Service Account']);

        Schema::create('t_application_flag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key')->unique();
            $table->boolean('value');
            $table->unsignedBigInteger('modified_by');
            $table->timestamps();

            $table->foreign('modified_by')->references('id')->on('t_user');
        });

        Schema::create('h_application_flag', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('key');
            $table->boolean('value');
            $table->unsignedBigInteger('modified_by');
            $table->timestamps();

            $table->foreign('modified_by')->references('id')->on('t_user');
        });

        $service_account = \App\Models\User::getServiceAccount()->id;

        $flag = new \App\Models\Flag();
        $flag->key = 'IS_POLL_OPENED';
        $flag->value = false;
        $flag->modified_by = $service_account;
        $flag->save();
        \App\Models\FlagHistory::addEntry(\App\Models\Flag::getByKey('IS_POLL_OPENED'));

        $flag = new \App\Models\Flag();
        $flag->key = 'IS_POLL_CLOSED';
        $flag->value = false;
        $flag->modified_by = $service_account;
        $flag->save();
        \App\Models\FlagHistory::addEntry(\App\Models\Flag::getByKey('IS_POLL_CLOSED'));

        $flag = new \App\Models\Flag();
        $flag->key = 'IS_RESULT_PUBLIC';
        $flag->value = false;
        $flag->modified_by = $service_account;
        $flag->save();
        \App\Models\FlagHistory::addEntry(\App\Models\Flag::getByKey('IS_RESULT_PUBLIC'));

        $flag = new \App\Models\Flag();
        $flag->key = 'IS_VERIFICATION_CLOSED';
        $flag->value = false;
        $flag->modified_by = $service_account;
        $flag->save();
        \App\Models\FlagHistory::addEntry(\App\Models\Flag::getByKey('IS_VERIFICATION_CLOSED'));
    }

    public function down()
    {
        Schema::dropIfExists('t_application_flags');
    }
}
