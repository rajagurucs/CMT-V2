<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbInitUserHealthDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_init_user_health_details', function (Blueprint $table) {
            //$table->id(); 
            $table->bigIncrements('health_update_id');            
            $table->string('myhealth_curr_prog')->nullable();
            $table->string('myhealth_curr_state');
            $table->string('mylifesatisfaction_curr_prog')->nullable();
            $table->string('mylifesatisfaction_curr_state');
            $table->string('mysocialnetwork_curr_prog')->nullable();
            $table->string('mysocialnetwork_curr_state');
            $table->string('mycommunitynetwork_curr_prog')->nullable();
            $table->string('mycommunitynetwork_curr_state');
            $table->string('mystresslevel_curr_prog')->nullable();
            $table->string('mystresslevel_curr_state');
            $table->string('myhealthissues_curr_prog')->nullable();
            $table->string('myhealthissues_curr_state');
            $table->string('myfamilydoctor_curr_prog')->nullable();
            $table->string('myfamilydoctor_curr_state');
            $table->string('myvisittofamilydoctor_curr_state')->nullable();
            $table->string('myvisittoclinic_curr_state');
            $table->string('myvisittoemergency_curr_state');
            $table->string('myvisittohospital_curr_state');
            $table->string('mydiseaseawareness_curr_prog');
            $table->string('mydiseaseawareness_curr_state');
            $table->string('mycmtprogramawareness_curr_prog')->nullable();
            $table->string('mycmtprogramawareness_curr_state');
            $table->string('myphysicalactiveness_curr_prog')->nullable();
            $table->string('myphysicalactiveness_curr_state');
            $table->string('cmtagent_curr')->nullable();
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
        Schema::dropIfExists('tb_init_user_health_details');
    }
}
