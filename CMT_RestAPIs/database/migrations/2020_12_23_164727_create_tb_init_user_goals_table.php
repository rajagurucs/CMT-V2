<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbInitUserGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_init_user_goals', function (Blueprint $table) {
            
            $table->bigIncrements('tb_user_details_goals_update_id');  
            //$table->string('goalId');          
            $table->string('user_goal_category_name');
            $table->string('user_goal_program_name');
            $table->string('user_goal_program_location');
            $table->string('user_goal_program_instructor');
            $table->date('user_goal_program_startdate');
            $table->date('user_goal_program_enddate');
            $table->string('user_goal_program_participantcomments')->nullable();
            $table->string('user_goal_program_additionalcomments')->nullable();
            $table->string('user_goal_program_status');
            $table->string('user_goal_program_RatingBefore');
            $table->string('user_goal_program_RatingAfter')->nullable();
            $table->timestamps();
           
            $table->bigInteger('userId')->unsigned()->index();
            $table->foreign('userId')->references('userId')->on('tb_init_user_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_init_user_goals');
    }
}
