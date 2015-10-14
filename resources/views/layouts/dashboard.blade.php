<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/11/15
 * Time: 7:39 PM
 */?>

<!DOCTYPE html>
<html>
<head>
    @include("includes.head")
</head>
<body>
<div class="wrapper">
    @include("includes.header")

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Lexmark Printer App</small>
            </h1>
            <!--Breadcrumb Area-->
            <ol class="breadcrumb">
                <li><a href="{{url()}}"><i class="fa fa-dashboard"></i> Home</a></li>

            </ol>
        </section>
        <!--Main Content-->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    @yield("content")
                </div>
            </div>
        </section>
    </div>

</div>
<script src="{{url()}}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{url()}}/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{url()}}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{url()}}/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{url()}}/plugins/iCheck/icheck.min.js"></script>
<script src="{{url()}}/dist/js/app.min.js"></script>
</body>
</html>
