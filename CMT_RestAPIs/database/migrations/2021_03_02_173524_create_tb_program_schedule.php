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
            $table->string('Category');
            $table->string('ProgramName');            
            $table->string('Description');
            $table->string('FromDate');
            $table->string('ToDate');
            $table->integer('UserID')->unsigned()->index();
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('ProgramID')->references('programId')->on('tb_community_programs')->onDelete('cascade');
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
