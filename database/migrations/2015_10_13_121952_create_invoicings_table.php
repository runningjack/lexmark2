<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create("invoicing",function(Blueprint $table){
            $table->increments('id');
            $table->integer("stack_id")->unsigned();
            $table->string("site",225);
            $table->string("user",225);
            $table->string("ip",64);
            $table->string("job_title");
            $table->dateTime("submit_date");
            $table->dateTime("final_date");
            $table->string("final_action",10);
            $table->string("final_site");
            $table->integer("number_of_pages");
            $table->string("release_ip",25);
            $table->string("release_user",25);
            $table->string("release_method",10);
            $table->string("job_color");
            $table->string("job_paper_size");
            $table->foreign("stack_id")->references("id")->on("invoicing_stack")->onDelete("cascade");
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
        //
    }
}
