<?php

namespace App\Http\Controllers;

use App\Bill;
use App\Branch;
use App\Invoicing;
use App\Invoicingstack;
use App\Paper;
use App\Price;
use App\Company;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Job;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use DB;
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
        return View("invoicing.index",['branches'=>Branch::all(),'companies'=>Company::all(),'jobs'=>$jobs,'title'=>'Invoicing Console']);
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

       /* $validator = Validator::make($request->all(), [
            'site' => 'required',
            'filexlx' => 'required'
        ]);*/
//|unique:posts|max:255
        /*if ($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }else{*/



      // print_r($request->all());
        /*if (!$request->hasFile('filexlx')) {
         exit;
        }*/

        $file = $request->file('filexlx');
        $fileName = $request->file('filexlx')->getClientOriginalName();
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
            $stack->company_id = $request->input('company_id');
            $stack->site_id    = $request->input('site');
            $stack->description = $request->input('description');
            $stack->file_url = $destinationPath;
            $stack->invoicing_date = $request->input('submit_date');
            $stack->created_at = date("Y-m-d H:i:s");
            $stack->updated_at = date("Y-m-d H:i:s");
            $stack->save();

            foreach($sheetData as $data){

                if($z !=1){
                    if(!empty($data["G"])){
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
                }
                $z++;
            }
        }catch (Exception $ex){
            echo $ex->getMessage();
        }
        //}

    }

    public function generateInvoice($id=""){
       // $input = $request->all();

        $company = Company::find($id);

        $ArrMain=[];
        $stacks = Invoicingstack::where("company_id","=",$company->id)->where("status","=",0)->get();
        $total =0;
        $myInvoice = new Bill();
        foreach($stacks as $stack){

            /**
             * Get values of all variables that are need to
             * compute cost and type of job done by looping
             * through the invoicing table by each stack id
             */
            $type           = "";
            $color          = "";
            $paper          ="";
            $numPages       =0;
            $cost           = "";
            $amount         =0;
            $site           ="";
            $description    ="";

            $printNo =0;
            $copyNo = 0;

            /**
             * For each loop of the invoicing table,
             * compute the cost of each print job and populate/create
             * the invoice detail table
             */
            $a3Arr =[];
            $a4Arr =[];

            $sumNoPagesA3Color =0 ;//+= $minvoice->number_of_pages;
            $sumAmountA3Color  =0 ;//$amount;
            $sumNoPagesA4Color =0;// $minvoice->number_of_pages;
            $sumAmountA4Color  =0;//$amount;

            $sumNoPagesA3Mono =0;// $minvoice->number_of_pages;
            $sumAmountA3Mono  =0;
            $sumNoPagesA4Mono =0;//0 $minvoice->number_of_pages;
            $sumAmountA4Mono  =0;//$amount;

            $sumTotal    = 0;

            $unitCostA3Mono     =   0;
            $unitCostA4Mono     =0;
            $unitCostA3Color    =   0;
            $unitCostA4Color    =0;

            $invoicing = DB::table("invoicing")->where("stack_id","=",$stack->id)->get();
            foreach($invoicing as $minvoice){ //One Location in loop
                $site =  Branch::where("id","=",$minvoice->site)->pluck("name");
                $a3Arr[] ="";
                $a4Arr[] ="";
                $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                if(strtolower($minvoice->final_action) =="p"){ //check if action type is print
                    /**
                     * check if colored or mono
                     */
                    $printNo ++;
                    if(strtolower($minvoice->job_color) =="y"){ //if

                        if(!empty($paperid)){
                            if(strtolower($minvoice->device_type) !="m"){ //this is condition to check when print devices is monochrome and print_job_type is Y
                                $description    =   "Print Jobs Color";
                                /*
                                DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                                    'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/
                                if($minvoice->job_paper_size == "A3"){
                                    $cost                   =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Color      +=  $minvoice->number_of_pages;
                                    $sumAmountA3Color       +=  $amount;
                                    $unitCostA3Color        =   $cost;
                                }else{
                                    $cost                   =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA4Color      +=  $minvoice->number_of_pages;
                                    $sumAmountA4Color       +=  $amount;

                                    $unitCostA4Color        =   $cost;
                                }
                            }else{

                                $description    =   "Print Jobs Mono";
                               /* DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                                    'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/
                                if($minvoice->job_paper_size == "A3"){
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA3Mono        +=  $amount;
                                    $unitCostA3Mono         =   $cost;

                                }else{
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA4Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA4Mono        +=  $amount;
                                    $unitCostA4Mono         =   $cost;

                                }
                            }
                        }
                    }elseif(strtolower($minvoice->job_color) =="n" ){
                        $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                        if(!empty($paperid)){


                            $description    =   "Print Jobs Mono";
                            /*DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                                'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/
                            if($minvoice->job_paper_size == "A3"){
                                $cost               =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount             =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA3Mono   +=  $minvoice->number_of_pages;
                                $sumAmountA3Mono    +=  $amount;
                                $unitCostA3Mono     =   $cost;

                            }else{
                                $cost               =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount             =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA4Mono   +=  $minvoice->number_of_pages;
                                $sumAmountA4Mono    +=  $amount;
                                $unitCostA4Mono     =   $cost;

                            }
                        }
                    }
                }elseif(strtolower($minvoice->final_action) =="c"){ //condition if action is copy
                    /**
                     *if action is c i.e photocopy
                     *no other condition is needed
                     */
                    $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                    if(!empty($paperid)){

                        $description    =   "Copy Jobs";
                       /* DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                            'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/

                        if($minvoice->job_paper_size == "A3"){
                            $cost               =   Price::where("job_id",2)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                            $amount             =   $cost * $minvoice->number_of_pages;
                            $sumNoPagesA3Mono   +=  $minvoice->number_of_pages;
                            $sumAmountA3Mono    +=  $amount;
                            $unitCostA3Mono     =   $cost;

                        }else{
                            $cost               =   Price::where("job_id",2)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                            $amount             =   $cost * $minvoice->number_of_pages;
                            $sumNoPagesA4Mono   +=  $minvoice->number_of_pages;
                            $sumAmountA4Mono    +=  $amount;
                            $unitCostA4Mono     =   $cost;

                        }
                    }
                   /* */
                }
            }//End of invoicing loop

            $sumTotal   +=  $sumAmountA4Mono;
            $sumTotal   +=  $sumAmountA3Mono;
            $sumTotal   +=  $sumAmountA4Color;
            $sumTotal   +=  $sumAmountA3Color;



        $a3Arr = ["a3mono"=>["nopages"=>$sumNoPagesA3Mono,"unitcost"=>$unitCostA3Mono,"netamount"=>$sumAmountA3Mono],
            "a3color"=>["nopages"=>$sumNoPagesA3Color,"unitcost"=>$unitCostA3Color,"netamount"=>$sumAmountA3Color]];


            if($sumNoPagesA3Mono > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site,'un_identity'=>'A3 Mono', 'description'=>"Print / Copy Mono A3", 'no_of_pages'=>$sumNoPagesA3Mono,
                'cost_per_page'=>$unitCostA3Mono,'paper_size'=>"A3",'amount'=>$sumAmountA3Mono,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
            if($sumNoPagesA3Color > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site,'un_identity'=>'A3 Color', 'description'=>"Print / Copy Color A3", 'no_of_pages'=>$sumNoPagesA3Color,
                    'cost_per_page'=>$unitCostA3Color,'paper_size'=>"A3",'amount'=>$sumAmountA3Color,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
            if($sumNoPagesA4Mono > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'un_identity'=>'A4 Mono', 'description'=>"Print / Copy Mono A4", 'no_of_pages'=>$sumNoPagesA4Mono,
                    'cost_per_page'=>$unitCostA4Mono,'paper_size'=>"A4",'amount'=>$sumAmountA4Mono,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
            if($sumNoPagesA4Color > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site,'un_identity'=>'A4 Color', 'description'=>"Print / Copy Color A4", 'no_of_pages'=>$sumNoPagesA4Color,
                    'cost_per_page'=>$unitCostA4Color,'paper_size'=>"A4",'amount'=>$sumAmountA4Color,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }



        $a4Arr = ["a4mono"=>["nopages"=>$sumNoPagesA4Mono,"unitcost"=>$unitCostA4Mono,"netamount"=>$sumAmountA4Mono],
            "a4color"=>["nopages"=>$sumNoPagesA4Color,"unitcost"=>$unitCostA4Color,"netamount"=>$sumAmountA4Color]];
        array_push($ArrMain, ["site"=>$minvoice->site,"a4"=>$a4Arr,"a3"=>$a3Arr,"sumTotal"=>$sumTotal]);
            $total +=$sumTotal;


        }//End of stack loop

        return View("invoicing.invoice",['InvoiceNo'=>'RJLEX/MAN/07',"total"=>$total,"company"=>$company,"branches"=>Branch::where("company_id",$company->id)->get(),"invoiceDatum"=>$ArrMain,"title"=>"Invoice"]);
    }

    public function postGenerateInvoice(Request $request){
        $input = $request->all();

        $company = Company::find($input['company_id']);

        $ArrMain=[];
        $stacks = Invoicingstack::where("company_id","=",$company->id)->where("status","=",0)->get();
        $total =0;
        foreach($stacks as $stack){

            /**
             * Get values of all variables that are need to
             * compute cost and type of job done by looping
             * through the invoicing table by each stack id
             */
            $type           = "";
            $color          = "";
            $paper          = "";
            $numPages       = 0;
            $cost           = "";
            $amount         = 0;
            $site           = "";
            $description    = "";

            $printNo =0;
            $copyNo = 0;

            /**
             * For each loop of the invoicing table,
             * compute the cost of each print job and populate/create
             * the invoice detail table
             */
            $a3Arr =[];
            $a4Arr =[];

            $sumNoPagesA3Color =0 ;//+= $minvoice->number_of_pages;
            $sumAmountA3Color  =0 ;//$amount;
            $sumNoPagesA4Color =0;// $minvoice->number_of_pages;
            $sumAmountA4Color  =0;//$amount;

            $sumNoPagesA3Mono =0;// $minvoice->number_of_pages;
            $sumAmountA3Mono  =0;
            $sumNoPagesA4Mono =0;//0 $minvoice->number_of_pages;
            $sumAmountA4Mono  =0;//$amount;

            $sumTotal    = 0;

            $unitCostA3Mono     =   0;
            $unitCostA4Mono     =0;
            $unitCostA3Color    =   0;
            $unitCostA4Color    =0;

            $invoicing = DB::table("invoicing")->where("stack_id","=",$stack->id)->where("final_date",">=",$input['date_from'])->where("final_date","<=","date_to")->get();
            foreach($invoicing as $minvoice){ //One Location in loop
                $site =  Branch::where("id","=",$minvoice->site)->pluck("name");
                $a3Arr[] ="";
                $a4Arr[] ="";
                $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                if(strtolower($minvoice->final_action) =="p"){ //check if action type is print
                    /**
                     * check if colored or mono
                     */
                    $printNo ++;
                    if(strtolower($minvoice->job_color) =="y"){ //if

                        if(!empty($paperid)){
                            if(strtolower($minvoice->device_type) !="m"){ //this is condition to check when print devices is monochrome and print_job_type is Y
                                $description    =   "Print Jobs Color";
                                /*
                                DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                                    'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/
                                if($minvoice->job_paper_size == "A3"){
                                    $cost                   =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Color      +=  $minvoice->number_of_pages;
                                    $sumAmountA3Color       +=  $amount;
                                    $unitCostA3Color        =   $cost;
                                }else{
                                    $cost                   =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA4Color      +=  $minvoice->number_of_pages;
                                    $sumAmountA4Color       +=  $amount;

                                    $unitCostA4Color        =   $cost;
                                }
                            }else{

                                $description    =   "Print Jobs Mono";
                                /* DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                                     'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/
                                if($minvoice->job_paper_size == "A3"){
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA3Mono        +=  $amount;
                                    $unitCostA3Mono         =   $cost;

                                }else{
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA4Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA4Mono        +=  $amount;
                                    $unitCostA4Mono         =   $cost;

                                }
                            }
                        }
                    }elseif(strtolower($minvoice->job_color) =="n" ){
                        $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                        if(!empty($paperid)){


                            $description    =   "Print Jobs Mono";
                            /*DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                                'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/
                            if($minvoice->job_paper_size == "A3"){
                                $cost               =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount             =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA3Mono   +=  $minvoice->number_of_pages;
                                $sumAmountA3Mono    +=  $amount;
                                $unitCostA3Mono     =   $cost;

                            }else{
                                $cost               =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount             =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA4Mono   +=  $minvoice->number_of_pages;
                                $sumAmountA4Mono    +=  $amount;
                                $unitCostA4Mono     =   $cost;

                            }
                        }
                    }
                }elseif(strtolower($minvoice->final_action) =="c"){ //condition if action is copy
                    /**
                     *if action is c i.e photocopy
                     *no other condition is needed
                     */
                    $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                    if(!empty($paperid)){

                        $description    =   "Copy Jobs";
                        /* DB::table("invoice_detail")->insert(['invoice_id' => 2, 'location' => $site, 'description'=>$description, 'no_of_pages'=>$numPages,
                             'cost_per_page'=>$cost,'paper_size'=>$minvoice->job_paper_size,'amount'=>$amount,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);*/

                        if($minvoice->job_paper_size == "A3"){
                            $cost               =   Price::where("job_id",2)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                            $amount             =   $cost * $minvoice->number_of_pages;
                            $sumNoPagesA3Mono   +=  $minvoice->number_of_pages;
                            $sumAmountA3Mono    +=  $amount;
                            $unitCostA3Mono     =   $cost;

                        }else{
                            $cost               =   Price::where("job_id",2)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                            $amount             =   $cost * $minvoice->number_of_pages;
                            $sumNoPagesA4Mono   +=  $minvoice->number_of_pages;
                            $sumAmountA4Mono    +=  $amount;
                            $unitCostA4Mono     =   $cost;

                        }
                    }
                    /* */
                }
            }//End of invoicing loop

            $sumTotal   +=  $sumAmountA4Mono;
            $sumTotal   +=  $sumAmountA3Mono;
            $sumTotal   +=  $sumAmountA4Color;
            $sumTotal   +=  $sumAmountA3Color;
            $a3Arr = ["a3mono"=>["nopages"=>$sumNoPagesA3Mono,"unitcost"=>$unitCostA3Mono,"netamount"=>$sumAmountA3Mono],
                "a3color"=>["nopages"=>$sumNoPagesA3Color,"unitcost"=>$unitCostA3Color,"netamount"=>$sumAmountA3Color]];
            $a4Arr = ["a4mono"=>["nopages"=>$sumNoPagesA4Mono,"unitcost"=>$unitCostA4Mono,"netamount"=>$sumAmountA4Mono],
                "a4color"=>["nopages"=>$sumNoPagesA4Color,"unitcost"=>$unitCostA4Color,"netamount"=>$sumAmountA4Color]];
            array_push($ArrMain, ["site"=>$minvoice->site,"a4"=>$a4Arr,"a3"=>$a3Arr,"sumTotal"=>$sumTotal]);
            $total +=$sumTotal;
        }//End of stack loop

        return View("invoicing.invoice",['InvoiceNo'=>'RJLEX/MAN/07',"total"=>$total,"company"=>$company,"branches"=>Branch::where("company_id",$company->id)->get(),"invoiceDatum"=>$ArrMain,"title"=>"Invoice"]);
    }

}
