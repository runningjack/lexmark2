<?php

namespace App\Http\Controllers;

use App\Paper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;


class PaperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $paper = Paper::all();
        return View("settings.paper",['papers'=>$paper,'title'=>'Job Papers Setting']);
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
        //
        $validator = Validator::make($request->all(), [
            'name' =>'required|unique:papers',
            'size' => 'required|unique:papers'
        ]);

        if ($validator->fails()) {
            if($request->ajax()){
                return response()->json($validator->messages());
                exit;
            }else{
                return \Redirect::back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }
        array_forget($request,"_token");

        $all_request = $request->all();
        $paper = new Paper();
        foreach($all_request as $key=>$value){
            $paper->$key = $value;
        }
        $paper->save();
        $papers = Paper::all();
        if($request->ajax()){
            if($papers){
                foreach($papers as $paper){
                    echo"
                        <tr>
                            <td>$paper->id</td>
                            <td>$paper->name</td>
                            <td>$paper->description</td>
                            <td>$paper->dimension</td>
                            <td>$paper->unit</td>

                            <td><button class='edtPaperLink btn-primary' cid='{$paper->id}' cname='{$paper->name}' cdescription='$paper->description' cdimension='$paper->dimension' cunit='$paper->unit'><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalPaperEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                        </tr>
                        ";
                }
            }
            exit;
        }
        return View("settings.paper",['papers'=>$papers,'title'=>'Job Papers Setting']);
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
            'size' => 'required'
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
        $paper = Paper::find($id);
        foreach($all_request as $key=>$value){
            /*
             * remove all underscore contained
             * in the edit form field
             */
            $key = preg_replace("/^_/","",$key);
            $paper->$key = $value;
        }


        if($request->ajax()){
            if($paper->update()){
                return response()->json("Paper Successfully Updated");
            }else{
                return response()->json("Unexpected Error! Paper could not be updated");
            }

            exit;
            // return \Redirect::back();
        }else{
            if($paper->update()){
                \Session::flash("success_message","Paper Successfully Updated");
            }else{
                \Session::flash("error_message","Unexpected Paper Company could not be updated");
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
        $paper    =   Paper::find($id);
        $invoice =  \DB::table("invoicing")->where("job_paper_size","=",$paper->name)->get();
        if(count($invoice)>0){
            return response()->json("This Record cannot be deleted!<br>Bill Transactions is already existing against this site");
            exit;
        }
        if($paper->delete()){
            Session::flash("success_message","Record Successfully deleted");
            echo "Paper Successfully Deleted";
            exit;
        }
    }
}
