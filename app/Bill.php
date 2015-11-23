<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    //
    protected $table = 'invoices';

    public function genInvoiceNo($cid){
        return  count(static::where("company_id",$cid)->get());
    }
}
