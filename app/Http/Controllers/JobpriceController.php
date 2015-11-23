<?php

namespace App\Http\Controllers;

use App\Job;
use App\Paper;
use App\Price;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JobpriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $input = $request->all();
        $validator = Validator::make($input, [
            'price' =>'required',
            'job_type' =>'required',
            'job_id' => 'required',
            'paper_id' => 'required'
        ]);
        if ($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        array_forget($request,"_token");

        $all_request = $request->all();
        $price = Price::find($id);
        $papers = Paper::all();
        $jobs = Job::all();
        foreach($all_request as $key=>$value){
            $price->$key = $value;
        }
        $price->update();
        $prices = Price::all();
        if($request->ajax()){
            if($prices){
                foreach($prices as $price){
                    echo"
                        <tr>
                            <td>$price->id</td>
                            <td>";
                    foreach($papers as $paper){
                        if($paper->id == $price->paper_id){
                            $paperid = $paper->name;
                            echo $paper->name.", ".$paper->size;
                        }
                    }


                    echo" </td>
                            <td>";
                    foreach($jobs as $job){
                        if($job->id == $price->job_id){
                            $jobid = $job->name;
                            echo $job->name;
                        }
                    }
                    echo"</td>
                            <td>$price->job_type</td>
                            <td>$price->price</td>
                            <td><button class='edtPriceLink btn-primary' cpaperid='$paperid' cjobtype='{$price->job_type}' cid='{$price->id}' cjobid='{$price->job_id}' cprice='$price->price'><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalPaperEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                        </tr>
                        ";
                }
            }
            exit;
        }else{




            try{
                if($price->update()){
                    \Session::flash("success_message","New Price Record Updated Successfully");
                    return \Redirect::back();
                }
            }catch(\Illuminate\Database\QueryException $e){
                \Session::flash("error_message",$e->getMessage());
                return \Redirect::back();
            }catch(\PDOException $e){
                \Session::flash("error_message",$e->getMessage());
                return \Redirect::back();
            }catch(\Exception $e){
                \Session::flash("error_message",$e->getMessage());
                return \Redirect::back();
            }

        }
        return View("settings.priceedit",['jobs'=>$jobs,'papers'=>$papers,'title'=>'Job Setting']);
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
