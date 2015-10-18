<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/19/15
 * Time: 2:29 PM
 */ ?>

@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalRoleNew">Add New Role</button>
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
                <th>Description</th>
                <th>Level</th>
                <th>Permission</th>
                <th>Date Created</th>
                <th ></th>
                <th ></th>
            </tr>
            </thead>
            <tbody id="tblCompany">
            <?php
            if($roles){
                foreach($roles as $role){
                    echo"
                        <tr>
                            <td>$role->id</td>
                            <td>$role->name</td>
                            <td>$role->description</td>
                            <td>$role->level</td>
                            <td></td>
                            <td>".date_format(date_create($role->created_at),"Y-m-d H:i:s")."</td>

                            <td><button class='edtRoleLink btn-primary' cid='{$role->id}' cname='{$role->name}' cdescription='$role->description' clevel='$role->level' ><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalRoleEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
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
                <th>Description</th>
                <th>Level</th>
                <th>Permission</th>
                <th>Date Created</th>

                <th colspan="2">Action</th>
            </tr>
            </tfoot>
        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->



<div class="modal fade" id="myModalRoleNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="regCompany" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Role</h4>
                </div>
                <div class="modal-body">

                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Role Name">
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>

                        <div class="form-group has-feedback">
                            <textarea class="form-control" placeholder="Description" name="description" id="description"></textarea>
                            <span class="glyphicon glyphicon-home form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <select class="form-control" name="phone" id="phone" placeholder="Phone">
                                <option value='1'>1</option>
                                <option value='2'>2</option>
                                <option value='3'>3</option>
                                <option value='4'>4</option>
                                <option value='5'>5</option>
                                <option value='6'>6</option>
                                <option value='7'>7</option>
                                <option value='8'>8</option>
                                <option value='9'>9</option>
                                <option value='10'>10</option>
                            </select>
                            <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                        </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Add Role</button>
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