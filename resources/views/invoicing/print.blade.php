<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/20/15
 * Time: 6:04 AM
 */
define("MAJOR", 'Naira');
define("MINOR", 'Kobo');
class Towords
{
    //

    var $pounds;
    var $pence;
    var $major;
    var $minor;
    var $words = '';
    var $number;
    var $magind;
    var $units = array('','one','two','three','four','five','six','seven','eight','nine');
    var $teens = array('ten','eleven','twelve','thirteen','fourteen','fifteen','sixteen','seventeen','eighteen','nineteen');
    var $tens = array('','ten','twenty','thirty','forty','fifty','sixty','seventy','eighty','ninety');
    var $mag = array('','thousand','million','billion','trillion');
    function Towords($amount, $major=MAJOR, $minor=MINOR) {
        $this->major = $major;
        $this->minor = $minor;
        $this->number = number_format($amount,2);
        list($this->pounds,$this->pence) = explode('.',$this->number);
        $this->words = " $this->major $this->pence$this->minor";
        if ($this->pounds==0)
            $this->words = "Zero $this->words";
        else {
            $groups = explode(',',$this->pounds);
            $groups = array_reverse($groups);
            for ($this->magind=0; $this->magind<count($groups); $this->magind++) {
                if (($this->magind==1)&&(strpos($this->words,'hundred') === false)&&($groups[0]!='000'))
                    $this->words = ' and ' . $this->words;
                $this->words = $this->_build($groups[$this->magind]).$this->words;
            }
        }
    }
    function _build($n) {
        $res = '';
        $na = str_pad("$n",3,"0",STR_PAD_LEFT);
        if ($na == '000') return '';
        if ($na{0} != 0)
            $res = ' '.$this->units[$na{0}] . ' hundred';
        if (($na{1}=='0')&&($na{2}=='0'))
            return $res . ' ' . $this->mag[$this->magind];
        $res .= $res==''? '' : ' and';
        $t = (int)$na{1}; $u = (int)$na{2};
        switch ($t) {
            case 0: $res .= ' ' . $this->units[$u]; break;
            case 1: $res .= ' ' . $this->teens[$u]; break;
            default:$res .= ' ' . $this->tens[$t] . ' ' . $this->units[$u] ; break;
        }
        $res .= ' ' . $this->mag[$this->magind];
        return $res;
    }


}



?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Robert Johnson Holdings | Invoice</title>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{url()}}/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{url()}}/bootstrap/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{url()}}/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{url()}}/plugins/iCheck/square/blue.css">
    <link rel="stylesheet" href="{{url()}}/dist/css/skins/skin-blue.min.css">
    <link rel="stylesheet" href="{{url()}}/dist/css/jquery-ui.min.css">
    <link rel="stylesheet" href="{{url()}}/dist/css/jquery.ui.theme.css">
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper" style="font-size: 11px !important">
    <!-- Main content -->
    <section class="invoice">
        <div class="row">

            <div class="col-xs-4">

                    <img src="{{url()}}/dist/img/logo.png" >


            </div>
            <div class="col-xs-4" style="text-align: center"><h2 class="page-header"><b>INVOICE</b></h2></div>
            <div class="col-xs-4"></div><!-- /.col -->

        </div>
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <address>
                    <strong>ROBERT JOHNSON TECHNOLOGIES LIMITED</strong><br>
                    286 Ikorodu Rd, Anthony<br>
                    Lagos-Nigeria<br>
                    Phone: (+234) 12918761<br>
                    Email: lexmarksupport@robertjohnsonholdings.com
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">

            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Invoice No: {{$invoice->invoice_no}}</b><br>
                <b>Invoice Date: {{$invoice->invoice_date}}</b><br>
                Bill To
                <address style="margin: 0px !important;">
                    <strong>{{$company->name}}</strong><br>
                    {{$company->address}}, @if(!empty($company->city)){{$company->city}}, @endif @if(!empty($company->state)){{$company->state}} @endif<br>
                                        @if(!empty($company->phone)) Phone: {{$company->phone}} @endif<br>


                </address>
                <img src="{{url()}}/dist/img/196765LOGO.jpg" style="margin: 0 !important; padding: 0 !important; width: 153px; height: 33px !important"  />
            </div>  <!-- /.col -->
        </div>  <!-- /.row -->
        <div class="row">
            <div class="col-xs-12 col-md-12" style="text-align: center"><p class="center" ><b><u>Lexmark Managed Print Services</u></b></p></div>
            <div class="col-xs-12 col-md-12" style="text-align: center"><p class="center"><b><u>Duration: {{$invoice->duration}}</u></b></p></div>
        </div>
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>No. of Pages</th>
                        <th>Cost per page (₦)</th>
                        <th>Net Amount (₦)</th>
                        <th>Total Amount (₦)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($invoiceItems){
                        $x = 1;


                        foreach($invoiceItems as $invoiceData ){
                            $sumTotal =0;
                            $a4ArrMono = \Illuminate\Support\Facades\DB::table("invoice_detail")->where("invoice_id",$invoiceData->invoice_id)->where("location",$invoiceData->location)
                                ->where('paper_size',"A4")->where("un_identity","A4 Mono")->get();
                            $a3ArrMono = \Illuminate\Support\Facades\DB::table("invoice_detail")->where("invoice_id",$invoiceData->invoice_id)->where("location",$invoiceData->location)
                                ->where('paper_size',"A3")->where("un_identity","A3 Mono")->get();
                            $a4ArrColor = \Illuminate\Support\Facades\DB::table("invoice_detail")->where("invoice_id",$invoiceData->invoice_id)->where("location",$invoiceData->location)
                                ->where('paper_size',"A4")->where("un_identity","A4 Color")->get();
                            $a3ArrColor = \Illuminate\Support\Facades\DB::table("invoice_detail")->where("invoice_id",$invoiceData->invoice_id)->where("location",$invoiceData->location)
                                ->where('paper_size',"A3")->where("un_identity","A3 Color")->get();

                            echo "<tr>
                            <td>$x</td>
                            <td>"; echo \Illuminate\Support\Facades\DB::table("branches")->where("name",$invoiceData->location)->pluck("city"); echo"</td>";
                            echo"<td>";
                                if(count($a4ArrMono)>0){
                                    echo "Print / Copy Jobs Mono A4 <br>";
                                }
                                if(count($a4ArrColor)>0){
                                    echo "Print / Copy Jobs Color A4 <br>";
                                }
                                if(count($a3ArrMono)>0){
                                    echo "Print / Copy Jobs Mono A3 <br>";
                                }
                                if(count($a3ArrColor)>0){
                                    echo "Print / Copy Jobs Color A3 <br>";
                                }
                            echo"</td>";
                            echo"<td>";
                                if(count($a4ArrMono)>0){
                                    echo number_format($a4ArrMono[0]->no_of_pages)."<br>";
                                    $sumTotal +=$a4ArrMono[0]->amount;
                                }
                                if(count($a4ArrColor)>0){
                                    echo number_format($a4ArrColor[0]->no_of_pages). "<br>";
                                    $sumTotal +=$a4ArrColor[0]->amount;
                                }
                                if(count($a3ArrMono)>0){
                                    echo number_format($a3ArrMono[0]->no_of_pages). "<br>";
                                    $sumTotal +=$a3ArrMono[0]->amount;
                                }
                                if(count($a3ArrColor)>0){
                                    echo number_format($a3ArrColor[0]->no_of_pages). "<br>";
                                    $sumTotal +=$a3ArrColor[0]->amount;
                                }
                            echo"</td>
                            <td>";
                                if(count($a4ArrMono)>0){
                                    echo number_format($a4ArrMono[0]->cost_per_page,2,'.',',')."<br>";
                                }
                                if(count($a4ArrColor)>0){
                                    echo number_format($a4ArrColor[0]->cost_per_page,2,'.',','). "<br>";
                                }
                                if(count($a3ArrMono)>0){
                                    echo number_format($a3ArrMono[0]->cost_per_page,2,'.',','). "<br>";
                                }
                                if(count($a3ArrColor)>0){
                                    echo number_format($a3ArrColor[0]->cost_per_page,2,'.',','). "<br>";
                                }
                            echo"</td>
                            <td>";
                                if(count($a4ArrMono)>0){
                                    echo number_format($a4ArrMono[0]->amount,2,'.',',')."<br>";
                                }
                                if(count($a4ArrColor)>0){
                                    echo number_format($a4ArrColor[0]->amount,2,'.',','). "<br>";
                                }
                                if(count($a3ArrMono)>0){
                                    echo number_format($a3ArrMono[0]->amount,2,'.',','). "<br>";
                                }
                                if(count($a3ArrColor)>0){
                                    echo number_format($a3ArrColor[0]->amount,2,'.',','). "<br>";
                                }
                            echo"</td>
                            <td>".number_format($sumTotal,2,'.',',')."</td>
                        </tr>";
                            $x++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p><b>Amount In Words: </b> <?php $obj = new  Towords($invoice->total); echo $obj->words; ?></p>
                <br>

            </div><!-- /.col -->
            <div class="col-xs-6">
                <!-- <p class="lead">Amount Due 2/22/2014</p>-->
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td>₦{{number_format($invoice->subtotal,2,'.',',')}}</td>
                        </tr>
                        <tr>
                            <th style="width:50%">5% VAT:</th>
                            <td>₦{{number_format($invoice->tax,2,'.',',')}}</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>₦{{number_format($invoice->total,2,'.',',')}}</td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <!-- this row will not appear when printing -->
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                ----------------------------------------------<br>
                Beka Phillips<br>
                (<i>Sales Manage</i>) <i>81024088452</i>
            </div>
            <div class="col-lg-4 col-xs-4"></div>
            <div class="col-lg-4 col-xs-4">
                ----------------------------------------------<br>
                E.O. Afuye<br>
                <i>Head of Finance</i>

            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-4 col-xs-4">
                <b>For {{$company->name}} Received By:</b> ----------------------------------------<br>
            </div>
        </div>

    </section><!-- /.content -->
</div><!-- ./wrapper -->
<!-- AdminLTE App -->
<script src="{{url()}}/dist/js/app.min.js"></script>
</body>
</html>
