<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/15/15
 * Time: 4:02 PM
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
@extends("layouts.tablelayout")
@section("content")

<section class="invoice" style="font-size: 11px !important">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <img src="{{url()}}/dist/img/logo.png" >
                <small class="pull-right"><b>INVOICE</b></small>
            </h2>
        </div><!-- /.col -->
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

            <address>
                <table>
                    <tr><td>Bank Name:</td><td>Zenith Bank Plc</td></tr>
                    <tr><td>Account No:</td><td>1010864930</td></tr>
                    <tr><td>Sort Code:</td><td>57150505</td></tr>
                    <tr><td>Bank Branch:</td><td>Anthony</td></tr>
                </table>

            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">

        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>TIN NO: 02345410-0001</b><br>
            <b>VAT NO: IUV10002500775</b><br>
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
                if($invoiceDatum){
                    $x = 1;
                    $sumTotal =0;
                    foreach($invoiceDatum as $invoiceData ){

                        echo "<tr>
                        <td>$x</td>
                        <td>"; //echo \Illuminate\Support\Facades\DB::table("branches")->where("name",$invoiceData->site)->pluck("city");
                        echo"</td>
                        <td>"; if (($invoiceData['a4']['a4color']['nopages']>0 )){ echo "Print / Copy Jobs Color A4 <br>";} if (($invoiceData['a4']['a4mono']['nopages']>0 )){ echo "Print / Copy Jobs Mono A4 <br>";}
                        if (($invoiceData['a3']['a3color']['nopages']>0 )){ echo "Print / Copy Jobs Color A3 <br>";} if (($invoiceData['a3']['a3mono']['nopages']>0 )){ echo "Print / Copy Jobs Mono A3 <br>";}
                        echo"</td>
                        <td>";
                        if (($invoiceData['a4']['a4color']['nopages']>0 )){ echo number_format($invoiceData['a4']['a4color']['nopages'])."</br>" ;} if (($invoiceData['a4']['a4mono']['nopages']>0 )){ echo number_format($invoiceData['a4']['a4mono']['nopages'])." <br>";}
                        if (($invoiceData['a3']['a3color']['nopages']>0 )){ echo number_format($invoiceData['a3']['a3color']['nopages'])."<br>";} if (($invoiceData['a3']['a3mono']['nopages']>0 )){ echo number_format($invoiceData['a3']['a3mono']['nopages'])."<br>";}
                        echo "</td>
                        <td>";
                        if (($invoiceData['a4']['a4color']['nopages']>0 )){ echo ($invoiceData['a4']['a4color']['unitcost'])."</br>" ;} if (($invoiceData['a4']['a4mono']['nopages']>0 )){ echo ($invoiceData['a4']['a4mono']['unitcost'])." <br>";}
                        if (($invoiceData['a3']['a3color']['nopages']>0 )){ echo ($invoiceData['a3']['a3color']['unitcost'])."<br>";} if (($invoiceData['a3']['a3mono']['nopages']>0 )){ echo ($invoiceData['a3']['a3mono']['unitcost'])."<br>";}
                        echo"</td>
                        <td>";
                        if (($invoiceData['a4']['a4color']['nopages']>0 )){ echo number_format($invoiceData['a4']['a4color']['netamount'],2,'.',',')."</br>" ;} if (($invoiceData['a4']['a4mono']['nopages']>0 )){ echo number_format($invoiceData['a4']['a4mono']['netamount'],2,'.',',')." <br>";}
                        if (($invoiceData['a3']['a3color']['nopages']>0 )){ echo number_format($invoiceData['a3']['a3color']['netamount'],2,'.',',')."<br>";} if (($invoiceData['a3']['a3mono']['nopages']>0 )){ echo number_format($invoiceData['a3']['a3mono']['netamount'],2,'.',',')."<br>";}
                        echo"</td>
                        <td>";
                            $stotal =0;
                            if($invoiceData['sumTotal'] !=0){
                                $stotal += $invoiceData['sumTotal'];
                            }

                        echo number_format($stotal,2,".",",") ."</td>

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
        <p>Amount In Words: <?php $obj = new Towords($invoice->total); echo $obj->words; ?></p>
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
            <b>Beka Phillips</b><br>
            <i>Sales Manage</i><br>
            <i>81024088452</i>
        </div>
        <div class="col-lg-4 col-xs-4"></div>
        <div class="col-lg-4 col-xs-4">
            ----------------------------------------------<br>
            <b>E.O. Afuye</b><br>
            <i>Head of Finance</i>

        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-4 col-xs-4">
            <b>For {{$company->name}} Received By:</b> ----------------------------------------<br>
        </div>
    </div>

    <div class="row no-print">
        <div class="col-xs-12">

            <a href="{{url()}}/invoicing/print/{{$invoice->id}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            <!--<button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
            <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>-->
        </div>
    </div>
</section>
@stop