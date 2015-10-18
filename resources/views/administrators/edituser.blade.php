<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/31/14
 * Time: 4:17 PM
 */
?>

<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 12/31/14
 * Time: 1:44 PM
 */

//initilize the page
require_once("inc/init.php");

//require UI configuration (nav, ribbon, etc.)
require_once("inc/config.ui.php");



$page_title = "Edit User";

$page_css[] = "your_style.css";
include("inc/header.php");

//include left panel (navigation)
//follow the tree in inc/config.ui.php
$page_nav["admin"]["sub"]["addnew"]["active"] = true;
include("inc/nav.php");

?>
    <script src="../../../js/app.config.js"></script>
    <!-- ==========================CONTENT STARTS HERE ========================== -->
    <!-- MAIN PANEL -->
    <div id="main" role="main">
    <?php
    //configure ribbon (breadcrumbs) array("name"=>"url"), leave url empty if no url
    //$breadcrumbs["New Crumb"] => "http://url.com"
    $breadcrumbs["Users"] = "";
    include("inc/ribbon.php");
    ?>

    <!-- MAIN CONTENT -->
    <div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <h1 class="page-title txt-color-blueDark"><i class="fa-fw fa fa-code"></i> Users <span>> Edit</span></h1>

        </div>

    </div>
    <section>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <div class="text-left">
                {{HTML::decode(HTML::linkRoute('userlist','<span class="btn-label"><i class="glyphicon glyphicon-back"></i> Back to Users'))}}
            </div>
        </div>
    </section>
    {{ Form::open(array('action'=>array('Backend\UserController@postEditUser', $myuser->id), 'method'=>'POST', 'class'=>'form-horizontal', 'files'=>true)) }}

    <div class="row">
    <div class="col-sm-9">



        <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" role="widget" style="">

            <header role="heading"><div class="jarviswidget-ctrls" role="menu">   <a href="javascript:void(0);" class="button-icon jarviswidget-toggle-btn" rel="tooltip" title="" data-placement="bottom" data-original-title="Collapse"><i class="fa fa-minus"></i></a>  </div>
                <span class="widget-icon"> <i class="fa fa-arrows-v"></i> </span>
                <h2 class="font-md"><strong>Set </strong> <i>Content</i></h2>

                <span class="jarviswidget-loader" style="display: none;"><i class="fa fa-refresh fa-spin"></i></span>
            </header>

            <!-- widget div-->
<input type="hidden" name="id" id="id" value="{{$myuser->id}}">
            <div role="content" style="display: block;">

                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->

                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body">

                    <fieldset>
                        <legend></legend>

                        @if(Session::has('message'))
                        <div class="alert alert-success fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-check"></i>{{Session::get('message')}}
                        </div>
                        @endif
                        @if(Session::has('error_message'))
                        <div class="alert alert-danger fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-check"></i>{{Session::get('error_message')}}
                        </div>
                        @endif
                        @if($errors->has("firstname"))
                        <div class="alert alert-danger fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-times"></i>{{$errors->first("firstname",":message")}}

                        </div>

                        @endif
                        @if($errors->has("lastname"))
                        <div class="alert alert-danger fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-times"></i>{{$errors->first("lastname",":message")}}

                        </div>

                        @endif
                        @if($errors->has("email"))
                        <div class="alert alert-danger fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-times"></i>{{$errors->first("email",":message")}}
                        </div>

                        @endif
                        @if($errors->has("phone"))
                        <div class="alert alert-danger fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-times"></i>{{$errors->first("phone",":message")}}
                        </div>

                        @endif


                        <div class="form-group">
                            <label class="col-md-2 control-label">Username</label>
                            <div class="col-md-10">
                                <input class="form-control" placeholder="Username" id="username" name="username" value="{{$myuser->username}}" type="text" required="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">email</label>
                            <div class="col-md-10">
                                <input class="form-control" placeholder="Email" id="email" name="email" type="text" value="{{$myuser->email}}" required="required" >
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-2 control-label">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" placeholder="Password" id="password" name="password" type="password" required="required" >
                            </div>
                        </div>-->

                        <hr>
                    </fieldset>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-2 col-lg-2 "></div>
                            <div class="col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Firstname</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="Password" id="firstname" name="firstname" type="text" value="{{$myuser->firstname}}" required="required" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Middlename</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="middlename" id="middlename" name="middlename" type="text" value="{{$myuser->middlename}}" >
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Lastname</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="Lastname" id="lastname" name="lastname" type="text" value="{{$myuser->lastname}}" required="required" >
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Telephone</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="phone" id="phone" name="phone" value="{{$myuser->phone}}" type="text" required="required" >
                                    </div>
                                </div>

                            </div>
                            <hr>
                        </div>
                        <p>&nbsp;</p>

                    </fieldset>

                    <input type="hidden" id="type" name="type" value="page">

                </div>
                <!-- end widget content -->



            </div>

            <!-- end widget div -->

        </div>

    </div>
    <div class="col-sm-3">

        <div class="jarviswidget jarviswidget-sortable" id="wid-id-12" data-widget-load="ajax/demowidget.php" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false" role="widget">

            <header role="heading" class=""><div class="jarviswidget-ctrls" role="menu"><a href="javascript:void(0);" class="button-icon jarviswidget-refresh-btn" data-loading-text="&nbsp;&nbsp;Loading...&nbsp;" rel="tooltip" title="" data-placement="bottom" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>     </div>
                <h2><strong>User</strong> <i> Sttings</i></h2>

                <span class="jarviswidget-loader" style="display: none;"><!--<i class="fa fa-refresh fa-spin"></i></span>--></header>

            <!-- widget div-->
            <div role="content" class="">

                <!-- widget edit box -->
                <div class="jarviswidget-editbox">
                    <!-- This area used as dropdown edit box -->

                </div>
                <!-- end widget edit box -->

                <!-- widget content -->
                <div class="widget-body">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-cog"></i>Save &amp; Publish</button>
                            <!--<a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-cog"></i> Save &amp; Publish</a>-->

                        </div>
                        <hr>





                            <?php
                            $user = \Toddish\Verify\Models\User::find(\Auth::user()->id);
                            //$myuser =  \Toddish\Verify\Models\User::find($id);
                            ?>
                            @if(\Auth::user()->id == $myuser->created_by_id )

                            @else
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="verified" name="verified"
                                @if($myuser->verified == "1")
                                {{ "value='1' checked"}}
                                @else
                                {{"value='0'"}}
                                @endif
                                class="checkbox style-0">
                                <span>Verified</span>
                            </label>

                        </div>

                        <div class="form-group">

                            <label class="checkbox-inline">
                                <input type="checkbox"  name="disabled"

                                @if($myuser->disabled == 0)
                                {{ "value='0' checked"}}
                                @else
                                {{"value='1' "}}
                                @endif
                                class="checkbox style-0">
                                <span>Active</span>
                            </label>

                        </div>
                            @endif

                        <div class="form-group">
                            <label>Assign Role </label>
                            <select class="form-control" id="role_id" name="role_id">


                                @foreach($roles as $page)
                                @if($page->id == $myrole[0]->role_id)
                                <option value="{{$page->id}}" selected>{{$page->name}}</option>
                                @else
                                <option value="{{$page->id}}">{{$page->name}}</option>
                                @endif
                                @endforeach


                            </select>
                        </div>

                        <div>
                            <a href="#" id="dialog_link" class="btn btn-labeled btn-primary">
                                <span class="btn-label"><i class="glyphicon glyphicon-plus"></i></span>Change Password</a>
                        </div>



                        <!-- <div class="form-group">
                             <label>Select Role</label>
                             <select class="form-control" id="layout" name="layout">
                                 <option>default</option>
                             </select>
                         </div>-->

                        <hr>

                    </div>

                </div>

                <!-- end widget content -->

            </div>
            <!-- end widget div -->

        </div>


    </div>
    </div>

    </form>
    </div>
    <!-- END MAIN CONTENT -->
    <div id="dialog_simple" title="Dialog Simple Title">
        <div id="msg"></div>
        <p>
        <form>

            <div class="row">
                <div class="col-md-3">
                    <h5>Enter New Password</h5>
                </div>
                <div class="col-md-9">
                    <section >
                        <input type="password" class="col-md-12" id="password2" name="password2"  value="">
                    </section>
                </div>
            </div>
        </form>
        </p>
    </div>
    </div>
    <!-- END MAIN PANEL -->
    <!-- ==========================CONTENT ENDS HERE ========================== -->
<?php
Session::flush();
?>
    <!-- PAGE FOOTER -->
<?php
// include page footer
include("inc/footer.php");
?>
    <!-- END PAGE FOOTER -->

<?php
//include required scripts
include("inc/scripts.php");
?>

    <!-- PAGE RELATED PLUGIN(S)-->



    <script>


        $(document).ready(function() {

            var perma =""
            // PAGE RELATED SCRIPTS
            $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
                _title : function(title) {
                    if (!this.options.title) {
                        title.html("&#160;");
                    } else {
                        title.html(this.options.title);
                    }
                }
            }));
            // switch style change
            $('input[name="checkbox-style"]').change(function() {
                //alert($(this).val())
                $this = $(this);

                if ($this.attr('value') === "switch-1") {
                    $("#switch-1").show();
                    $("#switch-2").hide();
                } else if ($this.attr('value') === "switch-2") {
                    $("#switch-1").hide();
                    $("#switch-2").show();
                }

            });

            // tab - pills toggle
            $('#show-tabs').click(function() {
                $this = $(this);
                if($this.prop('checked')){
                    $("#widget-tab-1").removeClass("nav-pills").addClass("nav-tabs");
                } else {
                    $("#widget-tab-1").removeClass("nav-tabs").addClass("nav-pills");
                }

            });

            $("#title").keyup(function(){

                perma = $(this).val()
                perma = perma.replace(/\s/g,"-")
                perma = perma.toLowerCase()
                //alert("all good")
                $("#permalink").val(perma)
            })




            $('#dialog_link').click(function() {
                $('#dialog_simple').dialog('open');
                return false;
            });

            $('#dialog_simple').dialog({
                autoOpen : false,
                width : 600,
                resizable : false,
                modal : true,
                title : "<div class='widget-header'><h4><i class='fa fa-warning'></i> Change Password</h4></div>",
                buttons : [{
                    html : "<i class='fa fa-save'></i>&nbsp; Save",
                    "class" : "btn btn-success",
                    click : function() {
                        var request =  $.ajax({
                            url:"edituser",
                            type:"post",
                            data:{action:"change password",password:$("#password2").val(),id:$("#id").val()},
                            dataType:"html"
                        })

                        request.done(function(data){
                            $("#msg").html('<div class="alert alert-success fade in">'+
                                '<button class="close" data-dismiss="alert">×</button>'+
                                '<i class="fa-fw fa fa-times">'+data+'</div>')
                        })

                        request.fail(function(){
                            $("#msg").html('<div class="alert alert-danger fade in">'+
                                '<button class="close" data-dismiss="alert">×</button>'+
                                '<i class="fa-fw fa fa-times">Request failed: </div>')//alert()
                        })

                        //$(this).dialog("close");
                    }
                }, {
                    html : "<i class='fa fa-times'></i>&nbsp; Cancel",
                    "class" : "btn btn-default",
                    click : function() {
                        $(this).dialog("close");
                    }
                }]
            });



        });

    </script>

<?php
//include footer
include("inc/google-analytics.php");
?>