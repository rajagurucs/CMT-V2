<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_feeds', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            $table->increments('id')->unique();                        
            $table->integer('UserID')->unsigned()->index();
            $table->string('Title')->nullable();
            $table->string('PostContent')->nullable();
            $table->string('File_Loc')->nullable();
            $table->string('LikeCount')->nullable();
            $table->string('DislikeCount')->nullable();
            // $table->string('Location');
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_feeds');
    }
}
