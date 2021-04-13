<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProgramSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_program_schedule', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('ProgramID');
            $table->string('Title');
            $table->integer('UserID')->unsigned()->index();
            $table->string('StartDate');
            $table->string('StartTime');
            $table->string('EndDate');
            $table->string('EndTime');
            $table->string('Instructor');
            $table->string('Location');
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('ProgramID')->references('programId')->on('tb_community_programs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_program_schedule');
    }
}
