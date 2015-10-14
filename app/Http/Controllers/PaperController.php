<?php

namespace App\Http\Controllers;

use App\Paper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
