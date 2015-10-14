<?php

namespace App\Http\Controllers;
use App\Branch;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        //
        array_forget($request,"_token");

        $all_request = $request->all();
        $branch = new Branch();
        foreach($all_request as $key=>$value){
            $branch->$key = $value;
        }
        $branch->save();
        $branches = Branch::all();
        if($request->ajax()){
            if($branches){
                foreach($branches as $company){
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
        return View("company.branches",['brances'=>$branches,'title'=>'Company Branches']);
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
