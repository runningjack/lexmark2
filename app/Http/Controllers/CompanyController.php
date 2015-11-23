<?php

namespace App\Http\Controllers;
use App\Bill;
use App\Branch;
use App\Company;

use App\Invoicingstack;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($request->all(), [
            'name' =>'required|min:5|unique:companies',
            'email' =>'required|min:5|unique:companies',
            'phone' => 'required|min:5|unique:companies'
        ]);
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages());
            }else{
                return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        $all_request = $request->all();
        array_forget($all_request,"_token");

        $company = new Company();
        foreach($all_request as $key=>$value){
            $company->$key = $value;
        }
        $company->save();
        $companies = Company::all();
        if($request->ajax()){
            return response()->json("record saved successfully");

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
        $stacks     =   Invoicingstack::where("company_id","=",$company->id)->where("status","=",0)->get();
        $stack2s     =   Invoicingstack::where("company_id","=",$company->id)->get();
        $invoice    =   Bill::where("company_id","=",$company->id)->get();
        $invoiceGroup = Bill::where("company_id","=",$company->id)->groupBy("invoice_date")->get();
        return View("company.companydetail",['invGp'=>$invoiceGroup,'stacks'=>$stacks,'stack2s'=>$stack2s,'invoices'=>$invoice,'company'=>$company,'branches'=>$branches,'title'=>'Company Detail']);
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
        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages());
            }else{
                return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

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
        if($company->update()){
            \Session::flash("success_message","Company Successfully Updated");
        }else{
            \Session::flash("error_message","Unexpected Error Company could not be updated");
        }
        $companies = Company::all();
        if($request->ajax()){

            response()->json("Company Successfully Updated");
            exit;
           // return \Redirect::back();
        }
        return View("company.index",['companies'=>$companies,'title'=>'Companies']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $company    =   Company::find($id);
        $invoice =  DB::table("invoices")->where("company_id","=",$id)->get();

        if(count($invoice)>0){
            return response()->json("This Record cannot be deleted!<br>Bill Transactions is already existing against this company");
            exit;
        }
        if($company->delete()){
            Session::flash("success_message","Record Successfully deleted");
            echo "Company Successfully Deleted";
            exit;
        }
    }
}
