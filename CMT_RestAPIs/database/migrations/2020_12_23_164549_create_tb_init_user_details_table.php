<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbInitUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_init_user_details', function (Blueprint $table) {
            
            $table->bigIncrements('userId');            
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('gender');
            $table->string('age');
            $table->string('streetAddress');
            $table->string('city');
            $table->string('province');
            $table->string('country');
            $table->string('zipCode');
            $table->string('phoneHome');
            $table->string('phoneCell');
            $table->string('phoneWork');
            $table->string('email')->unique();
            $table->string('firstLang');
            $table->string('EmerContactName');
            $table->string('EmerContactNo');
            $table->string('aboutUs');
            $table->string('ChildValue');
            $table->string('notes')->nullable();
            $table->string('notes_last_edited_byName')->nullable();
            $table->string('notes_last_edited_byRole')->nullable();
          
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
        Schema::dropIfExists('tb_init_user_details');
    }
}
