<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/13/15
 * Time: 12:08 PM
 */ ?>
@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalInvoicingNew">Add File</button>
    </div>
</div>



<div class="box">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div><!-- /.box-header -->
    <div class="row">
        <div class="col-xs-12">
            <?php  ?>
            @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="alert alert-success fade in">
                <button class="close" data-dismiss="alert">×</button>
                <i class="fa-fw fa fa-check"></i>{{\Illuminate\Support\Facades\Session::get('message')}}
            </div>
            @endif
            @if(\Illuminate\Support\Facades\Session::has('success_message'))
            <div class="alert alert-success fade in">
                <button class="close" data-dismiss="alert">×</button>
                <i class="fa-fw fa fa-check"></i>{{\Illuminate\Support\Facades\Session::get('success_message')}}
            </div>
            @endif
            @if(Session::has('error_message'))
            <div class="alert alert-danger fade in">
                <button class="close" data-dismiss="alert">×</button>
                <i class="fa-fw fa fa-check"></i>{{Session::get('error_message')}}
            </div>
            @endif


            <div class="col-xs-12"> @if ( ! empty( $errors ) )
                @foreach ( $errors->all() as $error )
                <div class="alert alert-danger fade in">
                    <button class="close" data-dismiss="alert">×</button>
                    <i class="fa-fw fa fa-times"></i>{{$error}}

                </div>

                @endforeach
                @endif</div>
        </div>
    </div>
    <div class="box-body">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Telephone</th>
                <th>Address</th>
                <th>Url</th>
                <th ></th>
                <th ></th>
            </tr>
            </thead>
            <tbody id="tblCompany">
            <?php
            if($jobs){
               /* foreach($companies as $company){
                    echo"
                        <tr>
                            <td>$company->id</td>
                            <td>$company->name</td>
                            <td>$company->email</td>
                            <td>$company->phone</td>
                            <td>$company->address</td>
                            <td>$company->web_url</td>
                            <td><button class='edtCompanyLink btn-primary' cid='{$company->id}' cname='{$company->name}' cemail='$company->email' cphone='$company->phone' caddress='$company->address' curl='$company->web_url' ><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalComapanyEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
                        </tr>
                        ";
                }*/
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
    </div><!-- /.box-body -->
</div><!-- /.box -->



<div class="modal fade" id="myModalInvoicingNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" id="regInvoice"  method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">XLX Job Sheet Upload</h4>
                </div>
                <div class="modal-body">
<?php // ?>
                        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}" />

                    <div class="form-group has-feedback">
                        <select class="form-control" name="company_id" id="company_id" required="required">
                            <option>--SELECT--</option>
                            <?php
                            if($companies){
                                foreach($companies as $company){
                                    echo "<option value='$company->id'>$company->name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                        <div class="form-group has-feedback">
                            <select class="form-control" name="site" id="site" required="required">
                                <option>--SELECT--</option>
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
                            <label>Date range:</label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right active" id="reservation" name="submit_date">
                            </div><!-- /.input group -->
                        </div>

                        <div class="form-group has-feedback">
                            <label for="filexlx">Description</label>
                            <textarea class="form-control" placeholder="Address" name="description" id="description"></textarea>
                            <span class="glyphicon glyphicon-home form-control-feedback"></span>
                        </div>

                        <div class="form-group">
                            <label for="filexlx">File input</label>
                            <input type="file" id="filexlx" name="filexlx">
                            <p class="help-block">Upload .xlx file here</p>
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


<div class="modal fade" id="myModalComapanyEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edtFrmCompany" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit Company Detail</h4>
                </div>
                <div class="modal-body">

                   <!-- <input type="hidden"  name="_token" value="{{ csrf_token() }}" />-->
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
@stop