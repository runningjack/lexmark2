<?php

namespace App\Http\Controllers;
use App\Branch;
use App\Company;

use App\Invoicingstack;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $companies = Company::all();
        return View("company.index",['companies'=>$companies,'title'=>'Companies']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        array_forget($request,"_token");

        $all_request = $request->all();
        $company = new Company();
        foreach($all_request as $key=>$value){
            $company->$key = $value;
        }
        $company->save();
        $companies = Company::all();
        if($request->ajax()){
            if($companies){
                foreach($companies as $company){
                    echo"
                        <tr>
                            <td>$company->id</td>
                            <td>$company->name</td>
                            <td>$company->email</td>
                            <td>$company->phone</td>
                            <td>$company->address</td>
                            <td>$company->web_url</td>
                        </tr>
                        ";
                }
            }
            exit;
        }
            return View("company.index",['companies'=>$companies,'title'=>'Companies']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $company = Company::find($id);
        $branches = Branch::where("company_id","=",$company->id)->get();
        $stacks     =   Invoicingstack::where("company_id","=",$company->id)->get();
        return View("company.companydetail",['stacks'=>$stacks,'company'=>$company,'branches'=>$branches,'title'=>'Company Detail']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        array_forget($request,"_token");
        $all_request = $request->all();
        $company = Company::find($id);
        foreach($all_request as $key=>$value){
            /*
             * remove all underscore contained
             * in the edit form field
             */
            $key = preg_replace("/^_/","",$key);
            $company->$key = $value;
        }
        $company->update();
        $companies = Company::all();
        if($request->ajax()){
            if($companies){
                foreach($companies as $company){
                    echo"
                        <tr>
                            <td>$company->id</td>
                            <td>$company->name</td>
                            <td>$company->email</td>
                            <td>$company->phone</td>
                            <td>$company->address</td>
                            <td>$company->web_url</td>
                            <td><button class='edtCompanyLink btn-primary' cid='{$company->id}' cname='{$company->name}' cemail='$company->email' cphone='$company->phone' caddress='$company->address' curl='$company->web_url' ><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalComapanyEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                        </tr>
                        ";
                }
            }
            exit;
        }
        return View("company.index",['companies'=>$companies,'title'=>'Companies']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
