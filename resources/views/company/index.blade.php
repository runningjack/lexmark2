<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/12/15
 * Time: 5:13 AM
 */
?>
@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalComapanyNew">Add New Company</button>
    </div>
</div>



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
                if($companies){
                    foreach($companies as $company){
                        echo"
                        <tr>
                            <td>$company->id</td>
                            <td><a href='".url()."/company/companydetail/$company->id'>$company->name</a></td>
                            <td>$company->email</td>
                            <td>$company->phone</td>
                            <td>$company->address</td>
                            <td>$company->web_url</td>
                            <td><button class='edtCompanyLink btn-primary' cid='{$company->id}' cname='{$company->name}' cemail='$company->email' cphone='$company->phone' caddress='$company->address' curl='$company->web_url' ><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalComapanyEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
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
    </div><!-- /.box-body -->
</div><!-- /.box -->



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
                        <input type="text" class="form-control" name="name" id="name" placeholder="Company name">
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


<div class="modal fade" id="myModalComapanyEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edtFrmCompany" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit Company Detail</h4>
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