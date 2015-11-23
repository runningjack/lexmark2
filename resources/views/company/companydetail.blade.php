<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/15/15
 * Time: 10:43 AM
 */
?>
@extends("layouts.default")
@section("content")


<!-- Main content -->
<section class="content">

<div class="row">
<div class="col-xs-12"> @if ( ! empty( $errors ) )
    @foreach ( $errors->all() as $error )
    <div class="alert alert-danger fade in">
        <button class="close" data-dismiss="alert">×</button>
        <i class="fa-fw fa fa-times"></i>{{$error}}
    </div>
    @endforeach
    @endif</div>
<div class="col-md-3">


    <!-- About Me Box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">About</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i>{{$company->name}}</strong>
            <p class="text-muted">
                {{$company->address}}
            </p>

            <hr>

            <strong><i class="fa fa-map-marker margin-r-5"></i> Location</strong>
            <p class="text-muted">{{$company->city}}, {{$company->state}}</p>

            <hr>
            <?php //print_r(\Illuminate\Support\Facades\Session::get("padat")) ?>
            <!--<div class="row">
                <div class="col-lg-8 pull-left">
                    <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalGenerateInvoice">Generate Invoice</button>
                </div>
            </div>-->
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<div class="col-md-9">
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li class="active"><a href="#activity" data-toggle="tab">Recent Activity</a></li>
    <li><a href="#timeline" data-toggle="tab">History</a></li>
    <li><a href="#settings" data-toggle="tab">Branches</a></li>
    <li><a href="#stacks" data-toggle="tab">Uploaded Files</a> </li>
</ul>
<div class="tab-content">
<div class="active tab-pane" id="activity">
    <!-- Post -->
    <div class="post">
        <div class="row">
            <div class="col-lg-2 pull-right">
                <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalInvoicingNew">Add File</button>
            </div>
        </div>
        <div class="user-block">
        <span class='username'>
                          <a href="#">Unprocessed Files Uploaded</a>
                          <a href='#' class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                        </span>
           <!-- <span class='description'>Shared publicly - 7:30 PM today</span>-->
        </div><!-- /.user-block -->
        @if(count($stacks)>0)
        <div class="row">
            <div class="col-lg-12">
                <table  class="table table-bordered table-striped">
                    <thead><tr><th>S/N</th><th>Site</th><th>file</th><th>Invoicing Date</th><th>No of Records</th><td>Action</td></tr></thead>
                    <tbody>
                    <?php
                    if($stacks){
                        $x =1;
                        $sitename ="";
                        foreach($stacks as $stack){
                            echo "<tr>
                                <td>$x</td><td>";
                                    foreach($branches as $branch){
                                        if($stack->site_id == $branch->id){
                                            echo $branch->name;
                                            $sitename =$branch->name;
                                        }
                                    }
                                echo"</td><td>$stack->file_url</td><td>".date_format(date_create($stack->create_at),"Y-m-d")."</td><td>$stack->row_count</td>
                                <td><button class='delLink btn-danger' dname='$stack->file_url for $sitename' url='/invoicing/deletestack/$stack->id'  data-target='#myDelete' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                            </tr>";
                            $x++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-lg-8 pull-left">
                        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalGenerateInvoice">Generate Invoice</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div><!-- /.post -->

</div><!-- /.tab-pane -->
<div class="tab-pane" id="timeline">
    <!-- The timeline -->
    <ul class="timeline timeline-inverse">
        <!-- timeline time label -->
        <?php
            if($invoices){
                foreach($invGp as $inv){
                    echo "<li class='time-label'>
                        <span class='bg-red'>". date_format(date_create($inv->invoice_date),"d M. Y")."</span>
                    </li>";
                foreach($invoices as $invoice){
                    if($inv->invoice_date == $invoice->invoice_date ){
                   echo" <li>
                            <i class='fa fa-file-text bg-blue'></i>
                            <div class='timeline-item'>
                                <span class='time'><i class='fa fa-clock-o'></i>".date_format(date_create($invoice->created_at),"H:i ")."</span>
                                <h3 class='timeline-header'><a href='#'>Invoice</a> generated for ".$invoice->duration."</h3>
                                <div class='timeline-body'>";
                                       echo" <div class='row'>
                        <!-- accepted payments column -->
                        <div class='col-xs-6'>
                            <p><h3>Invoice ID: $invoice->invoice_no</h3></p>
                            <p>Generated to $company->name</p>
                        </div><!-- /.col -->
                        <div class='col-xs-6'>
                           <!-- <p class='lead'>Amount Due 2/22/2014</p>-->
                            <div class='table-responsive'>
                                <table class='table'>
                                    <tr>
                                        <th style='width:50%'>Subtotal:</th>
                                        <td>₦".number_format($invoice->subtotal,2,'.',',')."</td>
                                    </tr>
                                    <tr>
                                        <th style='width:50%'>5% VAT:</th>
                                        <td>₦".number_format($invoice->tax,2,'.',',')."</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>₦".number_format($invoice->total,2,'.',',')."</td>
                                    </tr>
                                </table>
                            </div>
                        </div>";

                                echo "</div>
                                <div class='timeline-footer'>";?>

                                    <a href='{{url()}}/invoicexlxs/{{$invoice->file_url}}'  class='btn bg-green btn-xs'><i class='fa fa-download'></i> Download Report</a>

                                    <?php echo "<a href='".url()."/invoicing/print/".$invoice->id."' target='_blank' class='btn btn-primary btn-xs'> <i class='fa fa-file-o'></i> View Invoice</a>
                                    <a class='delLink btn btn-danger btn-xs btn-inv-del' dname='$invoice->duration' url='/invoicing/deleteinvoice/$invoice->id'  data-target='#myDelete' data-toggle='modal'><i class='fa fa-trash'></i> Delete</a>
                                </div>
                            </div>
                        </li>";
                        $invoiceStack  = \App\Invoicingstack::where("company_id","=",$invoice->company_id)->where("created_at","=",$invoice->created_at)->get();
                        foreach($invoiceStack  as $stack){
                            if(date_format(date_create($inv->invoice_date),"M") ==date_format(date_create($stack->created_at),"M") ){
                                echo "<li>
                                    <i class='fa fa-upload bg-green'></i>
                                    <div class='timeline-item'>
                                        <span class='time'><i class='fa fa-clock-o'></i>". date_format(date_create($stack->created_at),"H:i")."</span>
                                        <h3 class='timeline-header'><a href='#'>File Uploaded For </a>"; echo \App\Branch::where("id",$stack->site_id)->pluck("name"); echo"</h3>
                                        <div class='timeline-body'>
                                             <a href=''><i class='fa  fa-file-excel-o'></i> $stack->file_url</a>
                                        </div>
                                    </div>
                                </li>";
                            }
                        }
                    }
                }
                }
            }
        ?>

    </ul>
</div><!-- /.tab-pane -->

<div class="tab-pane" id="settings">

    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>

                    <th>Telephone</th>
                    <th>Address</th>
                    <th>Web Url</th>
                    <th colspan="2">Action</th>
                </tr>
                </thead>
                <tbody id="tblCompany">
                <?php
                if($branches){
                    foreach($branches as $branch){
                        echo"
                        <tr>
                            <td>$branch->id</td>
                            <td>$branch->name</td>

                            <td>$branch->phone</td>
                            <td>$branch->address</td>
                            <td>$branch->web_url</td>
                            <td><button class='edtBranchLink btn-primary' cid='{$branch->id}' cname='{$branch->name}' cemail='$branch->email' ccity='$branch->city' cstate='$branch->state' cphone='$branch->phone' caddress='$branch->address' curl='$branch->web_url' ><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='delLink btn-danger' dname='$branch->name' url='/company/branchdelete/$branch->id'  data-target='#myDelete' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                        </tr>
                        ";
                    }
                }else{
                    echo"<tr><td colspan='7'>No Record Found</td> </tr>";
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Address</th>
                    <th>Url</th>
                    <th colspan="2">Action</th>
                </tr>
                </tfoot>
            </table>
            <div class='row'>
                <div class="col-lg-2 pull-right">
                    <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalBranchNew">Add New Site</button>
                </div>
            </div>
        </div><!-- /.box-body -->
    </div>
</div><!-- /.tab-pane -->
<div class="tab-pane" id="stacks">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"></h3>
        </div><!-- /.box-header -->
        <div class="box-body">
        @if(count($stack2s)>0)

                <table id="example2"  class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Site</th>
                        <th>file</th>
                        <th>Invoicing Date</th>
                        <th>Rows</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($stack2s){
                        $x =1;
                        $sitename ="";
                        foreach($stack2s as $stack){
                            echo "<tr>
                                    <td>$x</td>
                                    <td>";
                            foreach($branches as $branch){
                                if($stack->site_id == $branch->id){
                                    echo $branch->city;
                                    $sitename =$branch->name;
                                }
                            }
                            echo"</td>
                            <td>$stack->file_url</td>
                            <td>".date_format(date_create($stack->create_at),"Y-m-d")."</td>
                            <td>$stack->row_count</td>
                                    <td><select class='changestackstatus' url='/invoicing/updatestack/$stack->id'>
                                        <option value=''>-Status-</option>
                                        <option value='0'>Active</option>
                                        <option value='1'>Inactive</option>
                                    </select></td>
                                    <td><button class='delLink btn-danger' dname='$stack->file_url for $sitename' url='/invoicing/deletestack/$stack->id'  data-target='#myDelete' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                                </tr>";
                            $x++;
                        }
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>S/N</th>
                        <th>Site</th>
                        <th>file</th>
                        <th>Invoicing Date</th>
                        <th>Rows</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
        @endif
    </div>
</div>
</div><!-- /.tab-content -->
</div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
<div class="modal fade" id="myModalGenerateInvoice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ action('InvoicingController@generateInvoice') }}"  id="genInvoice"  method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Generate Invoice</h4>
                </div>
                <div class="modal-body">
                    <?php // ?>
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}" />
                    <input type="hidden" id="company_id" name="company_id" value="{{$company->id}}" />
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="date_from" id="date_from" placeholder="Date From">
                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="date_to" id="date_to" placeholder="Date To">
                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalInvoicingNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ action('InvoicingController@upload') }}"  id="regInvoice"  method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">XLSX Job Sheet Upload</h4>
                </div>
                <div class="modal-body">
                    <?php // ?>
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}" />
                    <input type="hidden" id="company_id" name="company_id" value="{{$company->id}}" />
                    <div class="form-group has-feedback">
                        <select class="form-control" name="site" id="site" required="required">
                            <option value="">--SELECT SITE--</option>
                            <?php
                            if($branches){
                                foreach($branches as $branch){
                                    echo "<option value='$branch->id'>$branch->name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Invoice date</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control pull-right active" id="reservation" name="submit_date">
                        </div><!-- /.input group -->
                    </div>
                    <div class="form-group has-feedback">
                        <label for="filexlx">Description</label>
                        <textarea class="form-control" placeholder="File Description" name="description" id="description"></textarea>
                        <span class="glyphicon glyphicon-home form-control-feedback"></span>
                    </div>
                    <div class="form-group">
                        <label for="filexlx">File input</label>
                        <input type="file" id="filexlx" name="filexlx" placeholder="Upload .xlsx file here">
                        <p class="help-block">Upload .xlsx file here</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalComapanyNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="regCompany" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Company</h4>
                </div>
                <div class="modal-body">
                    <form id="regCompany" method="post">
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Company name" required="">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <textarea class="form-control" placeholder="Address" name="address" id="address"></textarea>
                            <span class="glyphicon glyphicon-home form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
                            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="web url" name="web_url" id="weburl">
                            <span class="glyphicon glyphicon-link form-control-feedback"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Add Company</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalBranchEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edtFrmBranch" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit Site Detail</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="name" id="_name" placeholder="Company name">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" name="email" id="_email" class="form-control" placeholder="Email">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <textarea class="form-control" placeholder="Address" name="address" id="_address"></textarea>
                        <span class="glyphicon glyphicon-home form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">

                        <input type="text" class="form-control" required="required" name="city" id="_city" placeholder="City">
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">

                        <input type="text" class="form-control" name="state" id="_state" placeholder="State">
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="phone" id="_phone" placeholder="Phone">
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="web url" name="web_url" id="_weburl">
                        <input type="hidden" class="form-control" placeholder="web url" name="id" id="id">
                        <span class="glyphicon glyphicon-link form-control-feedback"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalBranchNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"><!--action="{{ action('BranchController@store') }}"-->
            <form id="regBranch"   method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Site</h4>
                </div>
                <div class="modal-body">

                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" id="company_id" name="company_id" value="{{ $company->id }}" />

                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Branch Name">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <textarea class="form-control" required="" placeholder="Address" name="address" id="address"></textarea>
                            <span class="glyphicon glyphicon-home form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" required="required" name="city" id="city" placeholder="City">
                            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="state" id="state" placeholder="State">
                            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone">
                            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" placeholder="web url" name="web_url" id="weburl">
                            <span class="glyphicon glyphicon-link form-control-feedback"></span>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Add Site</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop





