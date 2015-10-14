<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/12/15
 * Time: 9:13 PM
 */?>

@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#myModalPriceNew">Add Price</button>
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
                <th>Paper</th>
                <th>Job</th>
                <th>Type</th>
                <th>Price</th>
                <th ></th>
                <th ></th>
            </tr>
            </thead>
            <tbody id="tblCompany">
            <?php
            if($prices){
                foreach($prices as $price){
                    echo"
                        <tr>
                            <td>$price->id</td>
                            <td>";
                            foreach($papers as $paper){
                                if($paper->id == $price->paper_id){
                                    echo $paper->name.", ".$paper->size;
                                }
                            }


                           echo" </td>
                            <td>";
                    foreach($jobs as $job){
                        if($job->id == $price->job_id){
                            echo $job->name;
                                }
                    }
                    echo"</td>
                            <td>$price->job_type</td>
                            <td>$price->price</td>
                            <td></td>
                            <td></td>
                        </tr>
                        ";
                }
            }else{
                echo"<tr><td colspan='7'>No Record Found</td> </tr>";
            }
            ?>


            </tbody>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->



<div class="modal fade" id="myModalPriceNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="regPrice" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Add New Price</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="_token" name="_token" value="{{ csrf_token() }}" />
                    <div class="form-group has-feedback">
                        <select  class="form-control" name="paper_id" id="paperid" >
                            <?php
                                if($papers){
                                    foreach($papers as $paper){
                                        echo "<option value='$paper->id'>$paper->name </option>";
                                    }
                                }
                            ?>
                        </select>

                    </div>

                    <div class="form-group has-feedback">
                        <select  class="form-control" name="job_id" id="jobid" >
                            <?php
                            if($jobs){
                                foreach($jobs as $job){
                                    echo "<option value='$job->id'>$job->name </option>";
                                }
                            }
                            ?>
                        </select>

                    </div>

                    <div class="form-group has-feedback">
                        <select  class="form-control" name="job_type" id="jobtype" >
                            <option value="mono">Monochrome</option>
                            <option value="color">Colored</option>
                        </select>

                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="price" id="price" placeholder="Price">

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