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
        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div><!-- /.col -->
<div class="col-md-9">
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
    <li class="active"><a href="#activity" data-toggle="tab">Recent Activity</a></li>
    <li><a href="#timeline" data-toggle="tab">History</a></li>
    <li><a href="#settings" data-toggle="tab">Branches</a></li>
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
                          <a href="#">Files Uploaded</a>
                          <a href='#' class='pull-right btn-box-tool'><i class='fa fa-times'></i></a>
                        </span>
            <span class='description'>Shared publicly - 7:30 PM today</span>

        </div><!-- /.user-block -->
        <div class="row">
            <div class="col-lg-12">
                <table  class="table table-bordered table-striped">
                    <thead><tr><th>S/N</th><th>Site</th><th>file</th><th>Invoicing Date</th></tr></thead>
                    <tbody>
                    <?php
                    if($stacks){
                        $x =1;
                        foreach($stacks as $stack){
                            echo "<tr>
                                <td>$x</td><td>";
                                    foreach($branches as $branch){
                                        if($stack->site_id == $branch->id){
                                            echo $branch->name;
                                        }
                                    }
                                echo"</td><td>$stack->file_url</td><td>".date_format(date_create($stack->create_at),"Y-m-d")."</td>
                            </tr>";
                            $x++;
                        }
                    }
                    ?>
                    </tbody>
                </table>

                <a href="{{url()}}/invoicing/invoice/{{$company->id}}" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-file-text"></i> Generate Invoice</a>
            </div>
        </div>

    </div><!-- /.post -->

</div><!-- /.tab-pane -->
<div class="tab-pane" id="timeline">
    <!-- The timeline -->
    <ul class="timeline timeline-inverse">
        <!-- timeline time label -->
        <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        <li>
            <i class="fa fa-envelope bg-blue"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>
                <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>
                <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs">Read more</a>
                    <a class="btn btn-danger btn-xs">Delete</a>
                </div>
            </div>
        </li>
        <!-- END timeline item -->
        <!-- timeline item -->
        <li>
            <i class="fa fa-user bg-aqua"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>
                <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
            </div>
        </li>
        <!-- END timeline item -->
        <!-- timeline item -->
        <li>
            <i class="fa fa-comments bg-yellow"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>
                <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>
                <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                </div>
                <div class="timeline-footer">
                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                </div>
            </div>
        </li>
        <!-- END timeline item -->
        <!-- timeline time label -->
        <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        <li>
            <i class="fa fa-camera bg-purple"></i>
            <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>
                <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
                <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                </div>
            </div>
        </li>
        <!-- END timeline item -->
        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>
    </ul>
</div><!-- /.tab-pane -->

<div class="tab-pane" id="settings">
    <form class="form-horizontal">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputName" placeholder="Name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="inputEmail" placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputName" placeholder="Name">
            </div>
        </div>
        <div class="form-group">
            <label for="inputExperience" class="col-sm-2 control-label">Experience</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSkills" class="col-sm-2 control-label">Skills</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="inputSkills" placeholder="Skills">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-danger">Submit</button>
            </div>
        </div>
    </form>
</div><!-- /.tab-pane -->
</div><!-- /.tab-content -->
</div><!-- /.nav-tabs-custom -->
</div><!-- /.col -->
</div><!-- /.row -->

</section><!-- /.content -->


<div class="modal fade" id="myModalInvoicingNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ action('InvoicingController@upload') }}"  id="regInvoice"  method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">XLX Job Sheet Upload</h4>
                </div>
                <div class="modal-body">
                    <?php // ?>
                    <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}" />
                    <input type="hidden" id="company_id" name="company_id" value="{{$company->id}}" />
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
