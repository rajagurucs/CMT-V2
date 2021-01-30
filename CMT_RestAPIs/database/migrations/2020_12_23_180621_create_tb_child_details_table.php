<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbChildDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_child_details', function (Blueprint $table) {
            //$table->id(); 
            $table->Increments('id')->unique();             
            $table->string('childFirstname');
            $table->string('childLastname');
            $table->string('childDob');            
            $table->bigInteger('parentId')->unsigned()->index();

            $table->foreign('parentId')->references('userId')->on('tb_init_user_details')->onDelete('cascade');
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
        Schema::dropIfExists('tb_child_details');
    }
}
