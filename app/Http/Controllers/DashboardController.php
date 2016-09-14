<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    //

    public function Index(){
        return View("dashboard",["companies"=>Company::all()]);
    }
}
