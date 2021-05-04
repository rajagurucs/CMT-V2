<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbInitUserExtraDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_init_user_extra_details', function (Blueprint $table) {
            //$table->id();
           $table->bigIncrements('extra_details_id');            
           $table->string('myHealth');
           $table->string('myLifeSatisfaction');
           $table->string('mySocialNetwork');
           $table->string('myCommunityNetwork');
           $table->string('myStressLevel');
           $table->string('myHealthIssues');
           $table->string('myFamilyDoctor');
           $table->string('myVisitToFamilyDoctor');
           $table->string('myVisitToClinic');
           $table->string('myVisitToEmergency');
           $table->string('myVisitToHospital');
           $table->string('myDiseaseAwareness');
           $table->string('myCmtProgramAwareness');
           $table->string('myPhysicalActiveness');
           $table->string('cmtAgent')->nullable();
           
           $table->bigInteger('userId')->unsigned()->index();
           $table->foreign('userId')->references('userId')->on('tb_init_user_details')->onDelete('cascade');

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
        Schema::dropIfExists('tb_init_user_extra_details');
    }
}
