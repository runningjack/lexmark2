<?php

namespace App\Http\Controllers;
use App\Branch;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use \Illuminate\Support\Facades\Validator;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $branches = Branch::all();
        return View("company.branches",['branches'=>$branches,"title"=>"Company Branches","companies"=>Company::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $validator = Validator::make($request->all(), [
            'name' =>'required|min:5|unique:branches',
            'email' =>'required|min:5|unique:branches',
            'city' =>'required',
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
        $branch = new Branch();
        foreach($all_request as $key=>$value){
            $branch->$key = $value;
        }
        if($request->ajax()){
            if($branch->save()){
                return response()->json("Site Successfully Created");
            }else{
                return response()->json("Unexpected Error Record Could not be saved");
            }
        }else{ //if post  is not AJAX
            if($branch->save()){
                \Session::flash("success_message","Site Successfully Created");
                return Redirect::back();
            }else{
                \Session::flash("error_message","Unexpected Error Role was not created");
                return Redirect::back();
            }
        }
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id="")
    {
        //
        //

        $validator = Validator::make($request->all(), [
            'name' =>'required',
            'city' =>'required',
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
        $branch = Branch::find($id);
        foreach($all_request as $key=>$value){
            $branch->$key = $value;
        }
        $branch->update();
        if($request->ajax()){
            if($branch->update()){
                $branches = Branch::all();
                    return response()->json("Company Successfully Updated");
                    exit;
            }else{
                echo 0; //to signify record not saved via ajax
            }
        }else{ //if post  is not AJAX
            if($branch->update()){
                \Session::flash("success_message","Role Successfully Updated");
                return Redirect::back();
            }else{
                \Session::flash("error_message","Unexpected Error! Role was not updated");
                return Redirect::back();
            }
        }
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
        $company    =   Branch::find($id);
        $invoice =  DB::table("invoice_detail")->where("branch_id","=",$id)->get();
        if(count($invoice)>0){
            return response()->json("This Record cannot be deleted!<br>Bill Transactions is already existing against this site");
            exit;
        }
        if($company->delete()){
            Session::flash("success_message","Record Successfully deleted");
            echo "Site Successfully Deleted";
            exit;
        }
    }
}
