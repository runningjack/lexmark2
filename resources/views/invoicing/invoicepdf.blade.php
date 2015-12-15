<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 11/19/15
 * Time: 2:34 PM
 */
/*define("MAJOR2", 'Naira');
define("MINOR2", 'Kobo');
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
    function Towords($amount, $major=MAJOR2, $minor=MINOR2) {
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


}*/

$company = \App\Company::find($company_id);

?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Robert Johnson Holdings | Invoice</title>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{url()}}/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <!--<link rel="stylesheet" href="{{url()}}/bootstrap/font-awesome/css/font-awesome.min.css">
     Ionicons
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">-->
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
    <style>
        .row {
            margin-right: -15px;
            margin-left: -15px;
        }
        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }
        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }
        .col-xs-12 {
            width: 100%;
        }
        .col-xs-11 {
            width: 91.66666667%;
        }
        .col-xs-10 {
            width: 83.33333333%;
        }
        .col-xs-9 {
            width: 75%;
        }
        .col-xs-8 {
            width: 66.66666667%;
        }
        .col-xs-7 {
            width: 58.33333333%;
        }
        .col-xs-6 {
            width: 50%;
        }
        .col-xs-5 {
            width: 41.66666667%;
        }
        .col-xs-4 {
            width: 33.33333333%;
        }
        .col-xs-3 {
            width: 25%;
        }
        .col-xs-2 {
            width: 16.66666667%;
        }
        .col-xs-1 {
            width: 8.33333333%;
        }
        .col-xs-pull-12 {
            right: 100%;
        }
        .col-xs-pull-11 {
            right: 91.66666667%;
        }
        .col-xs-pull-10 {
            right: 83.33333333%;
        }
        .col-xs-pull-9 {
            right: 75%;
        }
        .col-xs-pull-8 {
            right: 66.66666667%;
        }
        .col-xs-pull-7 {
            right: 58.33333333%;
        }
        .col-xs-pull-6 {
            right: 50%;
        }
        .col-xs-pull-5 {
            right: 41.66666667%;
        }
        .col-xs-pull-4 {
            right: 33.33333333%;
        }
        .col-xs-pull-3 {
            right: 25%;
        }
        .col-xs-pull-2 {
            right: 16.66666667%;
        }
        .col-xs-pull-1 {
            right: 8.33333333%;
        }
        .col-xs-pull-0 {
            right: auto;
        }
        .col-xs-push-12 {
            left: 100%;
        }
        .col-xs-push-11 {
            left: 91.66666667%;
        }
        .col-xs-push-10 {
            left: 83.33333333%;
        }
        .col-xs-push-9 {
            left: 75%;
        }
        .col-xs-push-8 {
            left: 66.66666667%;
        }
        .col-xs-push-7 {
            left: 58.33333333%;
        }
        .col-xs-push-6 {
            left: 50%;
        }
        .col-xs-push-5 {
            left: 41.66666667%;
        }
        .col-xs-push-4 {
            left: 33.33333333%;
        }
        .col-xs-push-3 {
            left: 25%;
        }
        .col-xs-push-2 {
            left: 16.66666667%;
        }
        .col-xs-push-1 {
            left: 8.33333333%;
        }
        .col-xs-push-0 {
            left: auto;
        }
        .col-xs-offset-12 {
            margin-left: 100%;
        }
        .col-xs-offset-11 {
            margin-left: 91.66666667%;
        }
        .col-xs-offset-10 {
            margin-left: 83.33333333%;
        }
        .col-xs-offset-9 {
            margin-left: 75%;
        }
        .col-xs-offset-8 {
            margin-left: 66.66666667%;
        }
        .col-xs-offset-7 {
            margin-left: 58.33333333%;
        }
        .col-xs-offset-6 {
            margin-left: 50%;
        }
        .col-xs-offset-5 {
            margin-left: 41.66666667%;
        }
        .col-xs-offset-4 {
            margin-left: 33.33333333%;
        }
        .col-xs-offset-3 {
            margin-left: 25%;
        }
        .col-xs-offset-2 {
            margin-left: 16.66666667%;
        }
        .col-xs-offset-1 {
            margin-left: 8.33333333%;
        }
        .col-xs-offset-0 {
            margin-left: 0;
        }


    </style>
</head>
<body>
<div class="wrapper" style="font-size: 11px !important">
<!-- Main content -->
<div class="invoice" style="font-size: 11px !important">
    <table class="row" style="width: 100%">
        <tr>
        <td class="col-sm-4 col-lg-4 col-md-4" style="width:33.33333333%;float:left">

            <img src="{{url()}}/dist/img/logo.png" >


        </td>
        <td class="col-sm-4 col-lg-4 col-md-4" style="text-align: center;width:33.33333333%; float: left"><h2 class="page-header"><b>INVOICE</b></h2></td>
        <td class="col-sm-4 col-lg-4 col-md-4" style="width: 33.33333333%; float: left"><p>&nbsp;</p></td><!-- /.col -->
        </tr>
    </table>
    <table class="row invoice-info">
        <tr>
        <td class="col-sm-4 col-lg-4 col-md-4 invoice-col" style="width:33.33333333%;float:left">
            <address>
                <strong>ROBERT JOHNSON TECHNOLOGIES LIMITED</strong><br>
                286 Ikorodu Rd, Anthony<br>
                Lagos-Nigeria<br>
                Phone: (+234) 12918761<br>
                Email: lexmarksupport@robertjohnsonholdings.com
            </address>
        </td><!-- /.col -->
        <td class="col-sm-4 col-lg-4 col-md-4 invoice-col" style="width:33.33333333%;float:left">
            <p><address style="color:#fff !mportant">
                <strong style="color:#fff !mportant"><span style="color:#fff !mportant"></span></strong><br>

            </address></p>
        </td><!-- /.col -->
        <td class="col-sm-4 col-lg-4 col-md-4 invoice-col" style="width:33.33333333%; float:right !important">
            <b>Invoice No: {{$invoice->invoice_no}}</b><br>
            <b>Invoice Date: {{$invoice->invoice_date}}</b><br>
            Bill To
            <address style="margin: 0px !important;">
                <strong>{{$company->name}}</strong><br>
                {{$company->address}}, @if(!empty($company->city)){{$company->city}}, @endif @if(!empty($company->state)){{$company->state}} @endif<br>
                @if(!empty($company->phone)) Phone: {{$company->phone}} @endif<br>


            </address>
            <img src="{{url()}}/dist/img/196765LOGO.jpg" style="margin: 0 !important; padding: 0 !important; width: 153px; height: 33px !important"  />
        </td>  <!-- /.col -->
        </tr>
    </table>  <!-- /.row -->
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
                    <th>Cost per page (Naira)</th>
                    <th>Net Amount (Naira)</th>
                    <th>Total Amount (Naira)</th>
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
        <div class="col-xs-6 col-lg-6 col-md-6" style="width: 49% !important; float:left">
            <p><b>Amount In Words: </b> <?php //$obj = new  Towords($invoice->total); echo $obj->words; ?></p>
            <br>

        </div><!-- /.col -->
        <div class="col-xs-6 col-lg-6 col-md-6" style="float: right; width:49%">

                <table class="table" style="float: right">
                    <tr>
                        <td ><b>Subtotal:</b></td>
                        <td>N {{number_format($invoice->subtotal,2,'.',',')}}</td>
                    </tr>
                    <tr>
                        <td ><b>5% VAT:</b></td>
                        <td>N {{number_format($invoice->tax,2,'.',',')}}</td>
                    </tr>
                    <tr>
                        <td><b>Total:</b></td>
                        <td>N {{number_format($invoice->total,2,'.',',')}}</td>
                    </tr>
                </table>

        </div><!-- /.col -->
    </div><!-- /.row -->
    <!-- this row will not appear when printing -->
    <br>
    <table class="row">
        <tr>
        <td class="col-lg-4 col-xs-4">
            ----------------------------------------------<br>
            Beka Phillips<br>
            (<i>Sales Manage</i>) <i>81024088452</i>
        </td>
        <td class="col-lg-4 col-xs-4"></td>
        <td class="col-lg-4 col-xs-4">
            ----------------------------------------------<br>
            E.O. Afuye<br>
            <i>Head of Finance</i>

        </td>
        </tr>
    </table>
    <br>
    <table class="row">
        <tr>
        <td class="col-lg-4 col-xs-4">
            <b>For {{$company->name}} Received By:</b> ----------------------------------------<br>
        </td>
        </tr>
    </table>
</div>
</div><!-- ./wrapper -->

</body>
</html>
