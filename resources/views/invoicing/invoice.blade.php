<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/15/15
 * Time: 4:02 PM
 */ ?>


@extends("layouts.tablelayout")
@section("content")
<div class="row">
    <div class="col-xs-6 col-md-6"></div>
    <div class="col-xs-6 col-md-6"><form action="{{ action('InvoicingController@postGenerateInvoice') }}" id="regCompany" method="post">
            <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />

            <input type="hidden" class="form-control" name="company_id" id="company_id" value="{{$company->id}}" >

            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="date_from" id="date_from" placeholder="Date From">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" name="date_to" id="date_to" placeholder="Date To">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
        </form>
    </div>
</div>
<section class="invoice">
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Robert Johnson Holdings
                <small class="pull-right">Date: {{date("Y-m-d")}}</small>
            </h2>
        </div><!-- /.col -->
    </div>
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            From
            <address>
                <strong>Robert Johnson Holdings</strong><br>
                286 Ikorodu Rd,<br>
                Anthony, Lagos<br>
                Phone: (804) 123-5432<br>
                Email: info@robertjohnsonholdings.com
            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Bill To
            <address>
                <strong>{{$company->name}}</strong><br>
                {{$company->address}}<br>
                @if(!empty($company->city)){{$company->city}}, @endif @if(!empty($company->state)){{$company->state}} @endif<br>
                @if(!empty($company->phone)) Phone: {{$company->phone}} @endif<br>
                @if(!empty($company->phone)) Email: {{$company->email}} @endif<br>
                @if(!empty($company->phone)) Web: {{$company->web_url}} @endif
            </address>
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <b>Invoice No: {{$InvoiceNo}}</b><br>
            <br>

            <p><img src="{{url()}}/dist/img/196765LOGO.jpg" width="250" height="54" /></p>
        </div><!-- /.col -->
    </div><!-- /.row -->
    <div class="row">
        <div class="col-xs-12 col-md-12" style="text-align: center"><p class="center" ><b><u>Lexmax Managed Print Services</u></b></p></div>
        <div class="col-xs-12 col-md-12" style="text-align: center"><p class="center"><b><u>Duration: </u></b></p></div>
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
                        <td>"; foreach ($branches as $branch){if($invoiceData['site'] == $branch->id){echo $branch->city;}} echo"</td>
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

        </div><!-- /.col -->
        <div class="col-xs-6">
           <!-- <p class="lead">Amount Due 2/22/2014</p>-->
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>₦{{number_format($total,2,'.',',')}}</td>
                    </tr>
                    <tr>
                        <th style="width:50%">5% VAT:</th>
                        <td>₦{{number_format($total,2,'.',',')}}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>₦{{number_format($total,2,'.',',')}}</td>
                    </tr>
                </table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
            <a href="{{url()}}/invoice/print" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
            <!--<button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment</button>
            <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF</button>-->
        </div>
    </div>
</section>
@stop