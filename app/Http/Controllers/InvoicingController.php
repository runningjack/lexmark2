<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Invoicing;
use App\Invoicingstack;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Mockery\CountValidator\Exception;


class InvoicingController extends Controller
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
        return View("invoicing.index",['branches'=>Branch::all(),'jobs'=>$jobs,'title'=>'Invoicing Console']);
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
        $file ="";echo base_path();
        print_r($request->all());
        $destinationPath ="./documents/";

        //$file = \Input::file('filexlx')->;
        $file = \Input::file('filexlx')->getClientOriginalName();
        var_dump($file);
        $request->file('filexlx')->move($destinationPath,"meda");
        dd($request->file('filexlx'));
        if ($request->hasFile('filexlx')) {
            //
            $file = $request->file('filexlx');
            var_dump($file);

        }else{
            //var_dump($file);
        }



        /*$objPHPExcel =  \PHPExcel_IOFactory::load($destinationPath.$file);

        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        print_r($sheetData);*/

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

    public function upload(Request $request){
        $file ="";

        $validator = Validator::make($request->all(), [
            'site' => 'required',
            'filexlx' => 'required'
        ]);
//|unique:posts|max:255
        if ($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{



       // print_r($request->all());
        if (!$request->hasFile('filexlx')) {
         exit;
        }
        $file = $request->file('filexlx');
        $fileName = $file->getClientOriginalName();
        $destinationPath =public_path()."/documents/";

        $destinationPath = $destinationPath.$fileName;
        if(file_exists($destinationPath)){
            unlink($destinationPath);
        }
        $request->file('filexlx')->move(public_path()."/documents/",$fileName);

        //$objPHPExcel = \PHPExcel_IOFactory::load($destinationPath.'PR-FullDataExport_2015_09_02_07_57_57_444IKJ.xlsx');

        /*$result ="";
        Excel::load($destinationPath.'PR-FullDataExport_2015_09_02_07_57_57_444IKJ.xlsx', function($reader) {
            $result = $reader->get();
        });*/

 //\App:: make ('excel');
        /* \Maatwebsite\Excel\Facades\Excel::create('Laravel Excel', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                $sheet->setOrientation('landscape');
            });
        })->export('xls');*/
        try{

            $objPHPExcel = \PHPExcel_IOFactory::load($destinationPath);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            //$sheet = Excel::filter('chunk')->load($destinationPath)->chunk(250, function($results){})->get();
            //$sheet = Excel::load($destinationPath, function($reader) {})->get();
            //print_r($sheetData);
            $z=1;
            $stack = new Invoicingstack();
            $stack->title = $request->input('site');
            $stack->description = $request->input('description');
            $stack->file_url = $destinationPath;
            $stack->invoicing_date = $request->input('submit_date');
            $stack->created_at = date("Y-m-d H:i:s");
            $stack->updated_at = date("Y-m-d H:i:s");
            $stack->save();


            foreach($sheetData as $data){

                if($z !=1){
                    $invoicing = new Invoicing();
                    $invoicing->stack_id = $stack->id;
                    $invoicing->site = $request->input('site');
                    $invoicing->user = $data["B"];
                    $invoicing->ip =$data["C"];
                    $invoicing->job_title = $data["D"];
                    $invoicing->submit_date = date_format(date_create($data["E"]),"Y-m-d H:i:s");
                    $invoicing->final_date = date_format(date_create($data["F"]),"Y-m-d H:i:s");
                    $invoicing->final_action = $data["G"];
                    $invoicing->final_site = $data["H"];
                    $invoicing->number_of_pages = $data["I"];
                    $invoicing->release_ip = $data["J"];
                    $invoicing->release_user = $data["K"];
                    $invoicing->release_method = $data["L"];
                    $invoicing->job_color = $data["M"];
                    $invoicing->job_paper_size = $data["N"];
                    $invoicing->job_paper_size = $data["O"];
                    $invoicing->device_name = $data["P"];
                    $invoicing->device_type = $data["Q"];
                    $invoicing->device_host = $data["R"];
                    $invoicing->created_at = date("Y-m-d H:i:s");
                    $invoicing->save();
                }
                $z++;
            }
        }catch (Exception $ex){
            echo $ex->getMessage();
        }
        }

    }
}
