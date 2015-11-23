<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/12/15
 * Time: 2:53 PM
 */ ?>

@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalPaperNew">Add New Paper</button>
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
                <th>Paper Name</th>
                <th>Paper Size</th>
                <th>Description</th>
                <th>Dimension</th>
                <th>Unit</th>

                <th colspan="2"></th>

            </tr>
            </thead>
            <tbody id="tblCompany">
            <?php
            if($papers){
                foreach($papers as $paper){
                    echo"
                        <tr>
                            <td>$paper->id</td>
                            <td>$paper->name</td>
                            <td>$paper->size</td>
                            <td>$paper->description</td>
                            <td>$paper->dimension</td>
                            <td>$paper->unit</td>
                            <td><button class='edtPaperLink btn-primary' csize='$paper->size' cid='{$paper->id}' cname='{$paper->name}' cdescription='$paper->description' cdimension='$paper->dimension' cunit='$paper->unit'><span  class='glyphicon glyphicon-pencil'></span></button></td>
                            <td><button class='delLink btn-danger' dname='$paper->name' url='/settings/paperdelete/$paper->id'  data-target='#myDelete' data-toggle='modal'><span  class='glyphicon glyphicon-trash'></span></button></td>
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
                <th>Size</th>
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



<div class="modal fade" id="myModalPaperNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="regPaper" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Paper</h4>
                </div>
                <div class="modal-body">

                        <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Paper Name ">
                            <span class="glyphicon glyphicon-file form-control-feedback"></span>
                        </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="size" id="size" placeholder="Paper Size">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                    </div>

                        <div class="form-group has-feedback">
                            <textarea class="form-control" placeholder="Description" name="description" id="description"></textarea>
                            <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control" name="dimension" id="dimension" placeholder="Dimension">
                            <span class="glyphicon glyphicon-screenshot form-control-feedback"></span>
                        </div>
                        <div class="form-group has-feedback">
                            <label>Select Unit</label>
                            <select class="form-control" name="unit" id="unit">
                                <option>--SELECT UNIT--</option>
                                <option value="Millimeter">mm × mm</option>
                                <option value="Inches">in × in</option>
                            </select>
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


<div class="modal fade" id="myModalPaperEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="edtFrmPaper" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit Company Detail</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden"  name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="name" id="_name" placeholder="Paper Name ">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="size" id="_size" placeholder="Paper Size ">
                        <span class="glyphicon glyphicon-file form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <textarea class="form-control" placeholder="Description" name="description" id="_description"></textarea>
                        <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="dimension" id="_dimension" placeholder="Dimension">
                        <input type="hidden" name="id" id="id" >
                        <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label>Select Unit</label>
                        <select class="form-control" name="unit" id="_unit">
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