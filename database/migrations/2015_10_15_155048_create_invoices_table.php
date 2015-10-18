<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create("invoices",function(Blueprint $table){
            $table->increments("id");
            $table->string("invoice_no");
            $table->dateTime("invoice_date");
            $table->integer("company_id")->unsigned();
            $table->decimal("subtotal",10,2);
            $table->decimal("discount",10,2);
            $table->decimal("tax",10,2);
            $table->decimal("total",10,2);
            $table->foreign("company_id")->references("id")->on("companies")->onDelete("cascade");
            $table->timestamps();
        });

        Schema::create("invoice_detail",function(Blueprint $table){
            $table->increments("id");
            $table->integer("invoice_id")->unsigned();
            $table->string("location");
            $table->text("description");
            $table->integer("no_of_pages");
            $table->decimal("cost_per_page",5,2);
            $table->decimal("amount",20,2);
            $table->foreign("invoice_id")->references("id")->on("invoices")->onDelete("cascade");
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
