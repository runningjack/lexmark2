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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Mockery\CountValidator\Exception;
use Barryvdh\DomPDF\PDF;
//use Barryvdh\DomPDF\PDF;


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
        $bill    =   Bill::find($id);

        if($bill->delete()){
            Session::flash("success_message","Record Successfully deleted");

            echo "Company Successfully Deleted";
            exit;
        }
    }
    public function destroyStack($id)
    {
        //
        $bill    =   Invoicingstack::find($id);
        if($bill->delete()){
            unlink(public_path().$bill->file_url);
            Session::flash("success_message","Record Successfully deleted");
            echo "Stack Successfully Deleted";
            exit;
        }
    }
    public function upload(Request $request){
        $file ="";
        $validator = Validator::make($request->all(), [
            'site' =>'required',
            'filexlx' =>'required',

        ]);
        if ($validator->fails()) {
            return \Redirect::back()
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('filexlx');
        $fileName = $request->file('filexlx')->getClientOriginalName();
        $destinationPath =public_path()."/documents/";

        $destinationPath = $destinationPath.$fileName;
        if(file_exists($destinationPath)){
            unlink($destinationPath);
        }
        $request->file('filexlx')->move(public_path()."/documents/",$fileName);
        try{

            $objPHPExcel = \PHPExcel_IOFactory::load($destinationPath);
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
            //$highestRow = $sheetData->getHighestRow(); // e.g. 10
            //$highestColumn = $sheetData->getHighestColumn(); // e.g 'F'

            $z=1;
            $stack = new Invoicingstack();
            $stack->title = $request->input('site');
            $stack->company_id = $request->input('company_id');
            $stack->site_id    = $request->input('site');
            $stack->description = $request->input('description');
            $stack->file_url = "/documents/".$fileName;
            $stack->invoicing_date = $request->input('submit_date');
            $stack->created_at = date("Y-m-d H:i:s");
            $stack->updated_at = date("Y-m-d H:i:s");
            //$stack->row_count = $highestRow;
            $stack->save();
            /*$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
            for($row =1; $row<= $highestRow; $row++){
                for($col=0; $col <= $highestColumnIndex; $col++ ){
                    $sheetData->getCellByColumnAndRow($col, $row)->getValue();
                }
            }*/

            foreach($sheetData as $data){

                if($z !=1){ //Skips the sheet headings
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
                        $invoicing->print_job_duplex = $data["N"];

                        //$invoicing->job_paper_size = $data["N"];
                        if( strtolower($data["O"]) == "unknown" || empty($data["O"]) ){
                            $invoicing->job_paper_size = "A4" ;
                        }else{
                            $invoicing->job_paper_size = $data["O"];
                        }

                        $invoicing->device_name = $data["P"];
                        $invoicing->device_type = $data["Q"];
                        $invoicing->device_host = $data["R"];
                        $invoicing->created_at = date("Y-m-d H:i:s");
                        $invoicing->save();
                    }
                }
                $z++;
            }

           $stack->row_count = $z;
            $stack->update();

            \Session::put("success_message","File successfully processed");
            return \Redirect::back();
        }catch (Exception $ex){
            echo $ex->getMessage();
        }catch(\Illuminate\Database\QueryException $e){
            \Session::put("error_message",$e->getMessage());
            return \Redirect::back();
        }catch(\PDOException $e){
            \Session::put("error_message",$e->getMessage());
            return \Redirect::back();
        }catch(\Exception $e){
            \Session::put("error_message",$e->getMessage());
            return \Redirect::back();
        } catch(PHPExcel_Reader_Exception $e) {
            \Session::put("error_message",$e->getMessage());
            return \Redirect::back();
        }
        //}

    }

    public function generateInvoice(Request $request,$id=""){

        $input      =   $request->all();
        $company    =   !empty($id) ? Company::find($id) : Company::find($input['company_id']);
        $ArrMain    =   [];
      //  print_r($input);
        if(count($input)>0 ){ //allow room for invoice to be processed for recent uploaded and date range
            $stacks     =   Invoicingstack::where("company_id","=",$company->id)->where("status","=",0)->get();
           // var_dump("ok ok");
        }else{
            $stacks     =   Invoicingstack::where("company_id","=",$company->id)->where("status","=",0)->get();
        }
        //$input['id']=$id;

        $total      =   0;
        $bill       =   new Bill();
        $invoiceno="";
        if(count($stacks)>0){
            $bill_no = $bill->genInvoiceNo($company->id)>0 ? $bill->genInvoiceNo($company->id) : "01";
            $invoiceno =  !empty($input['inv_no']) ? "RJLEX/".strtoupper(substr($company->name,0,3))."/".$bill_no : "RJLEX/".strtoupper(substr($company->name,0,3))."/". str_pad($input['inv_no'],3,"0",STR_PAD_LEFT);
            $bill->invoice_no       =   $invoiceno;
            $bill->created_at       =   date("Y-m-d H:i:s");
            $bill->updated_at       =   date("Y-m-d H:i:s");

            $bill->company_id       =   $company->id;
            $bill->invoice_date     =   date("Y-m-d H:i:s");
            $check = Bill::where("invoice_no","=",$invoiceno)->pluck("invoice_no");
            if(!empty($check)){
                echo "Invoice number already existing in database";
                exit;
            }
            $bill->save();
            //$invoiceno = "RJLEX/".strtoupper(substr($company->name,0,3))."/".$bill->genInvoiceNo();
        }


        $dateFrom   =   "2000-01-01";
        $dateTo     =   "2000-01-01";
        $objPHPExcel = new \PHPExcel();
        $m=0;
        $s=0;
        foreach($stacks as $stack){
            // Create a new worksheet called “My Data”
            $s++;
            $sheetName = "RJLEX_".strtoupper(substr($company->name,0,3))."_". $bill_no;
            $siteName =  Branch::where("id","=",$stack->site_id)->pluck("name");
            $myWorkSheet = new  \PHPExcel_Worksheet($objPHPExcel, $siteName);
            $objPHPExcel->addSheet($myWorkSheet,$m);/**/
            $objPHPExcel->setActiveSheetIndex($m);
            $m++;
            $site               ="";
            $siteName ="";
            $description        ="";
            $printNo            =0;
            $copyNo             = 0;

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
            $sumTotal         = 0;
            $unitCostA3Mono   =   0;
            $unitCostA4Mono   =0;
            $unitCostA3Color  =   0;
            $unitCostA4Color  =0;
            $x =1;
            $p=1;
            if(count($input)>0){
                $invoicing = DB::table("invoicing")->where("stack_id","=",$stack->id)->get(); //->where("final_date",">=",$input['date_from'])->where("final_date","<=","date_to")
            }else{
                $invoicing = DB::table("invoicing")->where("stack_id","=",$stack->id)->get();
            }

            //$dateFrom  = DB::table("invoicing")->where("stack_id","=",$stack->id)->max('final_date');  //DB::table("invoicing")->where()
            //$dateTo    = DB::table("invoicing")->where("stack_id","=",$stack->id)->min('final_date');
            foreach($invoicing as $minvoice){ //One Location in loop
                $froDate =new \DateTime("2000-01-01");
                $toDate=new \DateTime("2000-01-01");

                if($x == 1){
                    //$dateFrom = new \DateTime($minvoice->final_date);
                    //$dateTo = new \DateTime($minvoice->final_date);

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$x,"SITE");
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$x,"User ID");
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$x,"Submit IP");
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$x,"Print Job Name");
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$x,"Submit Date");
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$x,"Final Date");
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$x,"Final Action");
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$x,"Final Site");
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$x,"Number of Pages");
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$x,"Cost Per Page");
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$x,"Total Cost");
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$x,"Release IP");
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$x,"Release User") ;
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$x,"Release Method") ;
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$x,"Print Job Color");
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$x,"Print Job Duplex");
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$x,"Print Job Paper Size");
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$x,"Release Model");
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$x,"Release Model Type");
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$x,"Rrelease Host Name");
                }

                //$date = date_create_from_format("Y-m-d H:i:s",$minvoice->final_date);
                if(isset($input['date_from'])){
                    $dateFrom =  $input['date_from'];
                }else{
                    /*$froDate = $dateFrom;
                    if( (int)$date->getTimestamp() <= (int)$froDate->getTimestamp() ){
                        $dateFrom = new \DateTime($minvoice->final_date);
                    }*/
                }
                if(isset($input['date_to'])){
                    $dateTo =  $input['date_to'];
                }else{
                    /*$toDate = $dateTo;
                    if( (int)$date->getTimestamp() >= (int)$toDate->getTimestamp() ){
                        $dateTo = new \DateTime($minvoice->final_date);

                    }*/
                }
                $site =  Branch::where("id","=",$minvoice->site)->pluck("name");
                $a3Arr[] ="";
                $a4Arr[] ="";
               // if($minvoice->job_paper_size == "A3"){}
                $paperid = DB::table("papers")->where("name",$minvoice->job_paper_size)->pluck("id");
                if(strtolower($minvoice->final_action) == "p" || strtolower($minvoice->final_action) =="c"){ //check if action type is print
                    /**
                     * check if colored or mono
                     */
                    $p++;
                    if(strtolower($minvoice->device_type) =="c"){
                        if(strtolower($minvoice->job_color) =="y"){
                            if($minvoice->job_paper_size == "A3" || (($minvoice->job_paper_size == "Tabloid") || ($minvoice->job_paper_size =="Ledger"))){
                                if($minvoice->device_name == 'Lexmark X925' || ($minvoice->device_name == 'Lexmark X950' || $minvoice->device_name == 'Lexmark X950de') ){
                                    $cost                   =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Color      +=  $minvoice->number_of_pages;
                                    $sumAmountA3Color       +=  $amount; //not longer neccessory because cumulated pages could be multiplied by the unit cost
                                    $unitCostA3Color        =   $cost;

                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"Y") ;//
                                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);

                                }elseif(strtolower($minvoice->device_name) == 'lexmark x860' ){ # else if Lexmark X860 (a mono A3 printer) //|| strtolower($minvoice->device_name) == 'lexmark x860de'
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA3Mono        +=  $amount;//not longer neccessory because cumulated pages could be multiplied by the unit cost
                                    $unitCostA3Mono         =   $cost;

                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);

                                }else{ # otherwise its an A4 job for color not A3 as may be indicated in datafile but A4
                                    $cost                       =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                    $amount                     =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA4Color          +=  $minvoice->number_of_pages;
                                    $sumAmountA4Color           +=  $amount;//not longer neccessory because cumulated pages could be multiplied by the unit cost
                                    $unitCostA4Color            =   $cost;

                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"Y") ;//
                                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                                }

                            }else{
                                $cost                       =   Price::where("job_id",1)->where("job_type","color")->where("paper_id",$paperid)->pluck("price");
                                $amount                     =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA4Color          +=  $minvoice->number_of_pages;
                                $sumAmountA4Color           +=  $amount;//not longer neccessory because cumulated pages could be multiplied by the unit cost
                                $unitCostA4Color            =   $cost;

                                $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"Y") ;//
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                            }
                        }elseif(strtolower($minvoice->job_color) =="n"){
                            if($minvoice->job_paper_size == "A3" || (($minvoice->job_paper_size == "Tabloid") || ($minvoice->job_paper_size =="Ledger")) ){//&&
                                if(strtolower($minvoice->device_name) == 'lexmark mx860'){//de
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA3Mono        +=  $amount;//not longer neccessory because cumulated pages could be multiplied by the unit cost
                                    $unitCostA3Mono         =   $cost;

                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                                }elseif($minvoice->device_name == 'Lexmark X925' || ($minvoice->device_name == 'Lexmark X950' || $minvoice->device_name == 'Lexmark X950de') ){
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA3Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA3Mono        +=  $amount;//not longer neccessory because cumulated pages could be multiplied by the unit cost
                                    $unitCostA3Mono         =   $cost;

                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);

                                }else{ # otherwise its an A4 job for mono not A3 as may be indicated in datafile
                                    $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                    $amount                 =   $cost * $minvoice->number_of_pages;
                                    $sumNoPagesA4Mono       +=  $minvoice->number_of_pages;
                                    $sumAmountA4Mono        +=  $amount; //not longer neccessory because cumulated pages could be multiplied by the unit cost
                                    $unitCostA4Mono         =   $cost;

                                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                                }

                            }else{
                                $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount                 =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA4Mono       +=  $minvoice->number_of_pages;
                                $sumAmountA4Mono        +=  $amount; //not longer neccessory because cumulated pages could be multiplied by the unit cost
                                $unitCostA4Mono         =   $cost;

                                $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                            }
                        }

                    }elseif(strtolower($minvoice->device_type) =="m"){
                        if($minvoice->job_paper_size == "A3" || (($minvoice->job_paper_size == "Tabloid") || ($minvoice->job_paper_size =="Ledger"))  ){#if device type is a mono and paper is A3
                            if(strtolower($minvoice->device_name) == 'lexmark mx860'){ #de we need to be sure its an lexmark mx860de device
                                $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount                 =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA3Mono       +=  $minvoice->number_of_pages;
                                $sumAmountA3Mono        +=  $amount;//not longer neccessory because cumulated pages could be multiplied by the unit cost
                                $unitCostA3Mono         =   $cost;

                                $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                                $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                            }elseif((strtolower($minvoice->device_name) == 'lexmark x654de' || strtolower($minvoice->device_name)== 'lexmark x654') || (strtolower($minvoice->device_name) == 'lexmark t656' || strtolower($minvoice->device_name)== 'lexmark t656de')){ # otherwise its an A4 job for mono not A3 as may be indicated in script

                                $paperid = DB::table("papers")->where("name","A4")->pluck("id");
                                $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                                $amount                 =   $cost * $minvoice->number_of_pages;
                                $sumNoPagesA4Mono       +=  $minvoice->number_of_pages;
                                $sumAmountA4Mono        +=  $amount; //not longer neccessory because cumulated pages could be multiplied by the unit cost
                                $unitCostA4Mono         =   $cost;

                                $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                                $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                                $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                                $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                                $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                                $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                                $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                                $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                                $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                                $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                                $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                                $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                                $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                                $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                                $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,"A4");
                                $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                                $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                                $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                            }

                        }else{

                            $cost                   =   Price::where("job_id",1)->where("job_type","mono")->where("paper_id",$paperid)->pluck("price");
                            $amount                 =   $cost * $minvoice->number_of_pages;
                            $sumNoPagesA4Mono       +=  $minvoice->number_of_pages;
                            $sumAmountA4Mono        +=  $amount; //not longer neccessory because cumulated pages could be multiplied by the unit cost
                            $unitCostA4Mono         =   $cost;

                            $objPHPExcel->getActiveSheet()->setCellValue('A'.$p,$site);
                            $objPHPExcel->getActiveSheet()->setCellValue('B'.$p,$minvoice->user);
                            $objPHPExcel->getActiveSheet()->setCellValue('C'.$p,$minvoice->ip);
                            $objPHPExcel->getActiveSheet()->setCellValue('D'.$p,$minvoice->job_title);
                            $objPHPExcel->getActiveSheet()->setCellValue('E'.$p,$minvoice->submit_date);
                            $objPHPExcel->getActiveSheet()->setCellValue('F'.$p,$minvoice->final_date);
                            $objPHPExcel->getActiveSheet()->setCellValue('G'.$p,$minvoice->final_action);
                            $objPHPExcel->getActiveSheet()->setCellValue('H'.$p,$minvoice->final_site);
                            $objPHPExcel->getActiveSheet()->setCellValue('I'.$p,$minvoice->number_of_pages);
                            $objPHPExcel->getActiveSheet()->setCellValue('J'.$p,$cost);
                            $objPHPExcel->getActiveSheet()->setCellValue('K'.$p,$amount);
                            $objPHPExcel->getActiveSheet()->setCellValue('L'.$p,$minvoice->release_ip);
                            $objPHPExcel->getActiveSheet()->setCellValue('M'.$p,$minvoice->release_user);
                            $objPHPExcel->getActiveSheet()->setCellValue('N'.$p,$minvoice->release_method);
                            $objPHPExcel->getActiveSheet()->setCellValue('O'.$p,"N") ;//
                            $objPHPExcel->getActiveSheet()->setCellValue('P'.$p,$minvoice->print_job_duplex); //duplex
                            $objPHPExcel->getActiveSheet()->setCellValue('Q'.$p,$minvoice->job_paper_size);
                            $objPHPExcel->getActiveSheet()->setCellValue('R'.$p,$minvoice->device_name);
                            $objPHPExcel->getActiveSheet()->setCellValue('S'.$p,$minvoice->device_type);
                            $objPHPExcel->getActiveSheet()->setCellValue('T'.$p,$minvoice->device_host);
                        }
                    }

                    $printNo ++;

                }




                $x++;

            }//End of invoicing loop

            $b   = $p + 5;


            $sumAmountA3Color = $sumNoPagesA3Color * $unitCostA3Color;
            $sumAmountA3Mono = $sumNoPagesA3Mono * $unitCostA3Mono;
            $sumAmountA4Color = $sumNoPagesA4Color * $unitCostA4Color;
            $sumAmountA4Mono = $sumNoPagesA4Mono * $unitCostA4Mono;
            /**
             * Sum total of all net
             * amounts
             */
            $sumTotal   +=  $sumAmountA4Mono;
            $sumTotal   +=  $sumAmountA3Mono;
            $sumTotal   +=  $sumAmountA4Color;
            $sumTotal   +=  $sumAmountA3Color;




        $a3Arr = ["a3mono"=>["nopages"=>$sumNoPagesA3Mono,"unitcost"=>$unitCostA3Mono,"netamount"=>$sumAmountA3Mono],
            "a3color"=>["nopages"=>$sumNoPagesA3Color,"unitcost"=>$unitCostA3Color,"netamount"=>$sumAmountA3Color]];
            if($sumNoPagesA3Mono > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => $bill->id,'branch_id'=>$minvoice->site,'location' => $site,'un_identity'=>'A3 Mono', 'description'=>"Print / Copy Mono A3", 'no_of_pages'=>$sumNoPagesA3Mono,
                'cost_per_page'=>$unitCostA3Mono,'paper_size'=>"A3",'amount'=>$sumAmountA3Mono,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
            if($sumNoPagesA3Color > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => $bill->id,'branch_id'=>$minvoice->site, 'location' => $site,'un_identity'=>'A3 Color', 'description'=>"Print / Copy Color A3", 'no_of_pages'=>$sumNoPagesA3Color,
                    'cost_per_page'=>$unitCostA3Color,'paper_size'=>"A3",'amount'=>$sumAmountA3Color,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
            if($sumNoPagesA4Mono > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => $bill->id,'branch_id'=>$minvoice->site, 'location' => $site, 'un_identity'=>'A4 Mono', 'description'=>"Print / Copy Mono A4", 'no_of_pages'=>$sumNoPagesA4Mono,
                    'cost_per_page'=>$unitCostA4Mono,'paper_size'=>"A4",'amount'=>$sumAmountA4Mono,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
            if($sumNoPagesA4Color > 0){
                DB::table("invoice_detail")->insert(['invoice_id' => $bill->id,'branch_id'=>$minvoice->site, 'location' => $site,'un_identity'=>'A4 Color', 'description'=>"Print / Copy Color A4", 'no_of_pages'=>$sumNoPagesA4Color,
                    'cost_per_page'=>$unitCostA4Color,'paper_size'=>"A4",'amount'=>$sumAmountA4Color,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")]);
            }
        $a4Arr = ["a4mono"=>["nopages"=>$sumNoPagesA4Mono,"unitcost"=>$unitCostA4Mono,"netamount"=>$sumAmountA4Mono],
            "a4color"=>["nopages"=>$sumNoPagesA4Color,"unitcost"=>$unitCostA4Color,"netamount"=>$sumAmountA4Color]];
        array_push($ArrMain, ["site"=>$site,"a4"=>$a4Arr,"a3"=>$a3Arr,"sumTotal"=>$sumTotal]);
            $total +=$sumTotal;
            $stack->status = 1;
            $stack->update();
        }   // End of stack loop

        if(isset($input['date_from']) && isset($input['date_to'])){
            $duration = date_format(date_create($input['date_from']),"d M. Y") ." - ". date_format(date_create($input['date_to']),"d M. Y");
        }else{
           // $duration = date_format($dateFrom ,"d M. Y") ." - ". date_format($dateTo,"d M. Y");

        }

        define('BUDGETS_DIR', public_path()."/invoicexlxs/"); // I define this in a constants.php file
        $pdfPath ="";
        if (!is_dir(BUDGETS_DIR)){
            mkdir(BUDGETS_DIR, 0755, true);
        }

       $fileurl = "RJLEX_".strtoupper(substr($company->name,0,3))."_".date("Y-M-d")."_".time();
       $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save(BUDGETS_DIR.$fileurl.".xlsx");


        $outputName = $fileurl.".pdf"; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
        $pdfPath = BUDGETS_DIR.$outputName;
        $bill->pdf_url  =  $outputName;

        // File::put($pdfPath, PDF::loadView($pdf, 'A4', 'portrait')->output());

        $bill->subtotal         =   $total;
        $bill->tax              =   5/100 * $total;
        $bill->total            =   $total + $bill->tax;
        $bill->invoice_date     =   date("Y-m-d H:i:s");
        $bill->duration         =   $duration;
        $bill->file_url         =   $fileurl.".xlsx";
        $bill->update();
        $input["invoice"]       = $bill;
        $invoiceItems = DB::table("invoice_detail")->where("invoice_id",$bill->id)->groupBy("location")->get();
        $input["invoiceItems"] = $invoiceItems;
        //$pdf = new PDF($dompdf, $config, $app['files'], $app['view']);
        $pdf = App::make('dompdf.wrapper');
        //$pdf->set_base_path(public_path()."/bootstrap");->download($outputName)
        $pdf->loadView('invoicing.invoicepdf', $input)->setPaper('a4')->setOrientation('landscape')->save($pdfPath);
       //return $pdf->download($outputName);

       return View("invoicing.invoice",['invoice'=>$bill,"total"=>$total,"company"=>$company,"branches"=>Branch::where("company_id",$company->id)->get(),"invoiceDatum"=>$ArrMain,"title"=>"Invoice"]);
    }




    public function printInvoice($id){
        $invoice = Bill::find($id);
        $company = Company::find($invoice->company_id);
        $invoiceItems = DB::table("invoice_detail")->where("invoice_id",$invoice->id)->groupBy("location")->get();
        $a3Arr =[];
        $a4Arr =[];
        $ArrMain=[];
        $A4 ="";
        return View("invoicing.print",['company'=>$company,'invoiceItems'=>$invoiceItems,"invoice"=>$invoice,"invoiceDatum"=>false]);
    }

    public function downloadStack($id){

    }

    public function getExcelSheet($id){
        $objPHPExcel = new \PHPExcel();
        // Create a new worksheet called “My Data”
        $myWorkSheet = new  \PHPExcel_Worksheet($objPHPExcel, 'My Data');
        $objPHPExcel->createSheet($myWorkSheet,0);
        $objPHPExcel->getActiveSheet()->setCellValue('B8', 'Some value');
        $invoicing = Invoicing::where("invoice_id",$id)->groupBy();

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel2007");
        $objWriter->save("05featuredemo.xlsx");
    }


    public function updateStack(Request $request,$id){
        $mstack = Invoicingstack::find($id);
        $mstack->status = $request->input('mstatus');
        if($mstack->update()){
            echo "Status Successfully Changed";
        }
    }

    public function generatePDF($id){
        $input = array();
        $invoice = Bill::find($id);
        $input['invoice'] = $invoice;
        $input['id'] = $id;
        $company = Company::find($invoice->id);
        //$invoiceData = DB::table("invoice_detail")->where("invoice_id",$id);
        define('BUDGETS_DIR', './invoicexlxs/'); // I define this in a constants.php file
        $pdfPath ="";
        if (!is_dir(BUDGETS_DIR)){
            mkdir(BUDGETS_DIR, 0755, true);
        }
        $outputName =$fileurl = "RJLEX_".strtoupper(substr($company->name,0,3))."_".date("Y-M-d")."_".time().".pdf"; // str_random is a [Laravel helper](http://laravel.com/docs/helpers#strings)
        $pdfPath = BUDGETS_DIR.'/'.$outputName;
        $invoice->pdf_url  =  $outputName;
        $invoice->update();
        // File::put($pdfPath, PDF::loadView($pdf, 'A4', 'portrait')->output());
        $pdf= PDF::loadView('invoicing.invoicepdf', $input)->setPaper('a4')->setOrientation('landscape')->save($pdfPath);

    }



}
