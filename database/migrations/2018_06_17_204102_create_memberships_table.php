<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->enum('type', ['f2f', 'virtual', 'both']);
            $table->date('begin');
            $table->timestamps();
        });

        Schema::create('languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('code')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('language_membership', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            
            $table->integer('membership_id')->unsigned();
            $table->foreign('membership_id')->references('id')->on('memberships');
            
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
        Schema::dropIfExists('language_membership');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('memberships');
    }
}
