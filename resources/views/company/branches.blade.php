<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/12/15
 * Time: 1:53 PM
 */?>

@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalComapanyNew">Add New Branch</button>
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
            </tr>
            </thead>
            <tbody id="tblCompany">
            <?php
            if($branches){
                foreach($branches as $company){
                    echo"
                        <tr>
                            <td>$company->id</td>
                            <td>$company->name</td>
                            <td>$company->email</td>
                            <td>$company->phone</td>
                            <td>$company->address</td>
                            <td>$company->web_url</td>
                        </tr>
                        ";
                }
            }else{
                echo"<tr><td colspan='5'>No Record Found</td> </tr>";
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
            </tr>
            </tfoot>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->



<div class="modal fade" id="myModalComapanyNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="regBranch" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Company</h4>
                </div>
                <div class="modal-body">
                    <form id="regCompany" method="post">
                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group has-feedback">
                            <label>Select Company Name</label>
                            <select class="form-control" name="company_id" id="company_id">
                                <option>--SELECT COMPANY--</option>
                                <?php
                                if($companies){
                                   foreach($companies as $company){
                                       echo"<option value='{$company->id}'>$company->name</option>";
                                   }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group has-feedback">

                            <input type="text" class="form-control" name="name" id="name" placeholder="Branch Name">
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
                            <input type="text" class="form-control" name="city" id="city" placeholder="City">
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
                    <button type="submit" class="btn btn-primary" >Add Company</button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop