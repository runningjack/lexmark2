    <!-- MAIN CONTENT -->
    @extends("layouts.default")
    @section("content")
    <div id="box">

    <section>
        <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
            <div class="text-left">
                <a href="{{url()}}/administrators/index" class="btn btn-primary"> <span class="btn-label"><i class="glyphicon glyphicon-back"></i> Back to Users </a>
            </div>
        </div>
    </section>

<form action="{{ action('UserController@store') }}" method="post" class="form-horizontal">

    <div class="row">
    <div class="col-sm-9">



        <div class="jarviswidget jarviswidget-color-darken jarviswidget-sortable" id="wid-id-2" data-widget-editbutton="false" data-widget-colorbutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" role="widget" style="">
            <!-- widget div-->
            <div role="content" style="display: block;">
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
                        @if(Session::has('success_message'))
                        <div class="alert alert-success fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-check"></i>{{Session::get('success_message')}}
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


                        <div class="form-group">
                            <label class="col-md-2 control-label">Username</label>
                            <div class="col-md-10">
                                <input class="form-control" placeholder="Username" id="username" name="username" type="text" required="required" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">email</label>
                            <div class="col-md-10">
                                <input class="form-control" placeholder="Email" id="email" name="email" type="text" required="required" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">Password</label>
                            <div class="col-md-10">
                                <input class="form-control" placeholder="Password" id="password" name="password" type="password" required="required" >
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-md-2 control-label">Confirm password</label>
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
                                    <label class="col-md-3 control-label">First name</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="First name" id="firstname" name="firstname" type="text" required="required" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Middle name</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="middle name" id="middlename" name="middlename" type="text"  >
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-5 col-lg-5">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Last name</label>
                                    <div class="col-md-9">
                                        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}" />
                                        <input class="form-control" placeholder="Last name" id="lastname" name="lastname" type="text" required="required" >
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Telephone</label>
                                    <div class="col-md-9">
                                        <input class="form-control" placeholder="phone" id="phone" name="phone" type="text" required="required" >
                                    </div>
                                </div>

                            </div>
                            <hr>
                        </div>
                        <p>&nbsp;</p>

                    </fieldset>


                </div>
                <!-- end widget content -->



            </div>

            <!-- end widget div -->

        </div>

    </div>
    <div class="col-sm-3">

        <div>
            <!-- widget div-->
            <div role="content" class="">
                <div class="widget-body">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-cog"></i>Save &amp; Publish</button>
                            <!--<a class="btn btn-primary" href="javascript:void(0);"><i class="fa fa-cog"></i> Save &amp; Publish</a>-->
                        </div>
                        <hr>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="hidden" id="verified" name="verified" value="1" checked class="checkbox style-0">
                               <!-- <span>Verified</span>-->
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" id="disabled" name="disabled" value="1" checked class="checkbox style-0">
                               <!-- <span> Active </span> -->
                            </label>

                        </div>

                        <div class="form-group">
                            <label>Assign Role</label>
                            <select class="form-control" id="role_id" name="role_id">
                                <option value="">--SELECT ROLE--</option>
                                @foreach($roles as $page)
                                <option value="{{$page->id}}">{{$page->name}}</option>
                                @endforeach

                            </select>
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

    </div>
    <!-- END MAIN PANEL -->
    <!-- ==========================CONTENT ENDS HERE ========================== -->
    <!-- PAGE FOOTER -->
@stop