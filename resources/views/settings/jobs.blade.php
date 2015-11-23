<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/13/15
 * Time: 5:27 AM
 */ ?>

@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <!--<button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalJobNew">Add Job</button>-->
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
                <th>Date Created</th>
                <th>Date Modified</th>
                <!--<th ></th>
                <th ></th>-->
            </tr>
            </thead>
            <tbody id="tblCompany">
            <?php
            if($jobs){
                foreach($jobs as $job){
                    echo"
                        <tr>
                            <td>$job->id</td>
                            <td>$job->name</td>

                            <td>$job->description</td>
                            <td>$job->created_at</td>
                            <td>$job->updated_at</td>
                           <!-- <td><button class='edtJobLink btn-primary' cid='{$job->id}' cname='{$job->name}' cdescription='$job->description'><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='btn-danger'  data-target='#myModalPaperEdit' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>-->
                        </tr>
                        ";
                }
            }else{
                echo"<tr><td colspan='5'>No Record Found</td> </tr>";
            }
            ?>


            </tbody>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->



<div class="modal fade" id="myModalJobNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="regJob" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Job</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Job Title">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                    </div>


                    <div class="form-group has-feedback">
                        <textarea class="form-control" placeholder="Description" name="description" id="description"></textarea>
                        <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                    </div>



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Add New Paper</button>
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
                        <input type="text" class="form-control" name="_name" id="name" placeholder="Paper Name ">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <textarea class="form-control" placeholder="Description" name="_description" id="description"></textarea>
                        <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="_dimension" id="dimension" placeholder="Dimension">
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label>Select Unit</label>
                        <select class="form-control" name="_unit" id="unit">
                            <option>--SELECT UNIT--</option>
                            <option value="Millimeter">mm × mm</option>
                            <option value="Inches">in × in</option>
                        </select>
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