<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbProgramFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_program_files', function (Blueprint $table) {
            $table->increments('file_id')->unique();
            $table->string('Program_Name');
            $table->string('Sentfrom');
            $table->string('FileName')->unique();
            $table->string('UserType');
            $table->string('File_Loc');
            $table->string('usergrade')->nullable();
            $table->string('agentcomments')->nullable();
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
        Schema::dropIfExists('tb_program_files');
    }
}
