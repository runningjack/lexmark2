<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("company_id")->unsigned()->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('phone');
            $table->string('web_url');
            $table->string('contact');
            $table->foreign("company_id")->references("id")->on("companies")->onDelete("cascade");
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
