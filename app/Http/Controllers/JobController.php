<?php

namespace App\Http\Controllers;

use App\Job;
use App\Paper;
use App\Price;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $jobs = Job::all();
        return View("settings.jobs",['jobs'=>$jobs,'title'=>'Jobs Setting']);
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
        array_forget($request,"_token");

        $all_request = $request->all();
        $job = new Job();
        foreach($all_request as $key=>$value){
            $job->$key = $value;
        }
        $job->save();
        $jobs = Job::all();
        if($request->ajax()){
            if($jobs){
                foreach($jobs as $job){
                    echo"
                       <tr>
                            <td>$job->id</td>
                            <td>$job->name</td>

                            <td>$job->description</td>
                            <td>$job->created_at</td>
                            <td>$job->updated_at</td>
                            <td><button class='edtJobLink btn-primary' cid='{$job->id}' cname='{$job->name}' cdescription='$job->description'><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalPaperEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                        </tr>
                        ";
                }
            }
            exit;
        }
        return View("settings.jobs",['jobs'=>$jobs,'title'=>'Job Setting']);
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


    public function getPrice(){
        //
        $jobprices =  \DB::table("prices")->get();
        return View("settings.price",['prices'=>$jobprices,'papers'=>Paper::all(),'jobs'=>Job::all(),'title'=>'Job Price Setting']);
    }

    public function postPrice(Request $request){
        array_forget($request,"_token");

        $all_request = $request->all();
        $price = new Price();
        foreach($all_request as $key=>$value){
            $price->$key = $value;
        }
        $price->save();
        $prices = Price::all();
        if($request->ajax()){
            if($prices){
                foreach($prices as $price){
                    echo"
                       <tr>
                            <td>$price->id</td>
                            <td>$price->name</td>

                            <td>$price->description</td>
                            <td>$price->created_at</td>
                            <td>$price->updated_at</td>
                            <td></td>
                            <td></td>
                        </tr>
                        ";
                }
            }
            exit;
        }
        return View("settings.price",['prices'=>$prices,'papers'=>Paper::all(),'jobs'=>Job::all(),'title'=>'Job Price Setting']);
    }
}
