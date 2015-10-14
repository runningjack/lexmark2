<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricejobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("prices",function(Blueprint $table){
            $table->increments("id");
            $table->integer("paper_id")->unsigned();
            $table->integer("job_id")->unsigned();
            $table->enum("job_type",["mono","colored"]);
            $table->decimal("price",5,2);
            $table->timestamps();
            $table->foreign("paper_id")->references("id")->on("papers");
            $table->foreign("job_id")->references("id")->on("jobs");
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
