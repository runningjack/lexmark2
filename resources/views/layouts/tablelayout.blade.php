<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/12/15
 * Time: 5:50 AM
 */?>

<!DOCTYPE html>
<html>
<head>
    @include("includes.head")
    <link rel="stylesheet" href="{{url()}}/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="{{url()}}/plugins/daterangepicker/daterangepicker-bs3.css">
</head>
<body>
<div class="wrapper">
@include("includes.header")
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{$title}}
        <small>Listing</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<div class="row">
<div class="col-xs-12">
@yield("content")
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.0
    </div>
    <strong>Copyright &copy; 2014-2015 <a href="javascript:void(0)">Robert Johnson Holdings</a>.</strong> All rights reserved.
</footer>

<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<script src="{{url()}}/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="{{url()}}/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{url()}}/plugins/iCheck/icheck.min.js"></script>
<script src="{{url()}}/plugins/jQueryUI/jquery-ui.min.js"></script>

<script src="{{url()}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url()}}/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="{{url()}}/plugins/datatables/dataTables.bootstrap.min.js"></script>

<script src="{{url()}}/dist/js/app.min.js"></script>
<script src="{{url()}}/dist/js/jquery.validate.min.js"></script>
<script src="{{url()}}/dist/js/jquery.form.min.js"></script>

<script>


    $(function () {
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $('#reservation').datepicker(

            {
                dateFormat: 'yy-mm-dd',
                minDate: '+5d',
                changeMonth: true


            }
        ).datepicker("setDate", new Date());

        var id
        var validator = $('#regCompany').validate({
            rules: {
                email: {
                    required: true
                },
                name: {
                    required: true
                }
            },submitHandler: function(form) {
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}
                });
                $("#myModalComapanyNew").modal("hide")
            }
        });
        var validator = $('#regBranch').validate({
            rules: {email:{required: true},company_id: {required: true},name: {required: true},address: {required: true},phone: {required: true}
            },submitHandler: function(form) {
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}
                });
                $("#myModalComapanyNew").modal("hide")
            }
        });


        var validator = $('#regPaper').validate({
            rules: {name: {required: true},size: {required: true}
            },submitHandler: function(form) {
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}
                });
                $("#myModalPaperNew").modal("hide")
            }
        });


        var validator = $('#regJob').validate({
            rules: {name: {required: true}
            },submitHandler: function(form) {
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}
                });
                $("#myModalJobNew").modal("hide")
            }
        });

        var validator = $('#regPrice').validate({
            rules: {price: {required: true}
            },submitHandler: function(form) {
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}
                });
                $("#myModalPriceNew").modal("hide")
            }
        });

        $(".edtCompanyLink").each(function(){
            var e = $(this)
            $(this).click(function(){
                var cid,cemail,cname,caddress,cphone,curl;cid = e.attr('cid');id = cid
                $("#id").val(e.attr('cid')); $("#_email").val(e.attr('cemail'));$("#_name").val(e.attr('cname'));$("#_address").val(e.attr('caddress'));$("#_phone").val(e.attr('cphone'));$("#_weburl").val(e.attr('curl'));
                $('#myModalComapanyEdit').modal("show")
            })
        })

        var validator = $('#edtFrmCompany').validate({
            rules: {email:{required: true},name: {required: true},address: {required: true},phone: {required: true}
            },submitHandler: function(form) {
                $.ajax({url: '<?php echo url() ?>/company/companyupdate/'+id,type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}});$("#myModalComapanyEdit").modal("hide")
            }
        });

        var validator = $('#delFrmCompany').validate({
            rules: {email:{required: true},name: {required: true},address: {required: true},phone: {required: true}
            },submitHandler: function(form) {
                $.ajax({url: '<?php echo url() ?>/company/companydelete/'+id,type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data)}else{alert(data);}}});$("#myModalComapanyEdit").modal("hide")
            }
        });


    });
</script>
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
</body>
</html>