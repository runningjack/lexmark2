<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Job;
use App\Http\Controllers\Controller;
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
       // print_r($request->all());

        $destinationPath =public_path()."/documents/";

        $destinationPath = $destinationPath.'dataexcel.xlsx';

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

            //$objPHPExcel = \PHPExcel_IOFactory::load($destinationPath);
           // $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);


            $sheet = Excel::filter('chunk')->load($destinationPath)->chunk(250, function($results){})->get();
            //$sheet = Excel::load($destinationPath, function($reader) {})->get();
            print_r($sheet);
        }catch (Exception $ex){
            echo $ex->getMessage();
        }



        /*Excel::load($destinationPath, function ($reader) {

            // var_dump($reader->get());

             /*foreach ($reader->toArray() as $row) {
                   //User::firstOrCreate($row);

               }
        });*/

        //var_dump($result);
        //$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

        /*Excel::load($destinationPath.'PR-FullDataExport_2015_09_02_07_57_57_444IKJ.xlsx',function($render){
           $result = ($render);
        });*/

       // print_r($sheetData);
        $z=1;
       /* foreach($sheetData as $data){
            if($z !=1){
                $stockprice = new \Corporateaction();
                $stockprice->company                 =   preg_replace(array("/^\'/","/\'$/","/\?+/"),"",\DB::connection()->getPdo()->quote($sheetData[$z]["A"]));
                $stockprice->dividend                 =   preg_replace(array("/^\'/","/\'$/"),"",\DB::connection()->getPdo()->quote($sheetData[$z]["B"]));
                $stockprice->bonus                   =   preg_replace(array("/^\'/","/\'$/"),"",\DB::connection()->getPdo()->quote($sheetData[$z]["C"]));
                $stockprice->closure                   =   preg_replace(array("/^\'/","/\'$/"),"",\DB::connection()->getPdo()->quote($sheetData[$z]["D"]));
                $stockprice->AGM_date                    =   preg_replace(array("/^\'/","/\'$/"),"",\DB::connection()->getPdo()->quote($sheetData[$z]["E"]));
                $stockprice->payment_date                  =  preg_replace(array("/^\'/","/\'$/"),"",\DB::connection()->getPdo()->quote($sheetData[$z]["F"]));
                $stockprice->action_date                 =   $pricelistdate;
                $stockprice->stacklist_id               =$liststack->id;

                $stockprice->save();
            }
            $z++;
        }*/
    }
}
