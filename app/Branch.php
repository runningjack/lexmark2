<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Validator;

class Branch extends Model
{
    //
    public static $rules = array(

        'name'=>'required',
        'phone'=>'required',
        'city'=>'required',

        'email'=>'required|min:10|unique:branches'
    );

    public static function validate($data){
        //$validate = new Validator(,array $data, static::$rules);
        return Validator::make($data, static::$rules);
    }
}
