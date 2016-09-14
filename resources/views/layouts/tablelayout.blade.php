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
    <h1><strong>
        {{$title}}</strong>
        <small>Listing</small>
    </h1>
    <h3>
        <?= !empty($companyname) ? $companyname : "" ?>
    </h3>
    <ol class="breadcrumb">
        <li><a href="{{url()}}"><i class="fa fa-dashboard"></i> Home</a></li>

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



<div class="modal" id="myProcess">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <div id="transProcess" style=' width:317px; margin:10px auto' ><img src='<?= url();?>/dist/img/bigLoader.gif'  ><h4>Processing Request... Please Wait!</h4></div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<div class="modal" id="myDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Data Delete Console</h4>
            </div>
            <div class="modal-body delInfo">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <a href=""  class="del btn btn-primary" >Delete</a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>




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
        var l,p;
        var d=$(".myDelete");l=$("a.del");p=$("#myProcess")

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $('#reservation').datepicker(
            {
                dateFormat: 'yy-mm-dd',
                changeMonth: true
            }
        ).datepicker("setDate", new Date());

        $('#date_from').datepicker(
            {
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3,
                onClose: function( selectedDate ) {
                    $( "#date_to" ).datepicker( "option", "minDate", selectedDate );
                }
            }
        );


        $('#date_to').datepicker(
            {
                defaultDate: "+1w",
                changeMonth: true,
                numberOfMonths: 3,
                onClose: function( selectedDate ) {
                    $( "#date_from" ).datepicker( "option", "maxDate", selectedDate );
                }
            }
        );

        var id
        var validator = $('#regCompany').validate({
            rules: {
                email: {
                    required: true
                },
                name: {
                    required: true
                }
            }, highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalComapanyNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'html',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });
        var validator = $('#regBranch').validate({
            rules: {email:{required: true},company_id: {required: true},name: {required: true},address: {required: true},phone: {required: true}
            },highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalComapanyNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
                }
        });

        var validator = $('#regPaper').validate({
            rules: {name: {required: true},size: {required: true}
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalPaperNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'html',
                    success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}}});
            }
        });



        var validator = $('#edtFrmPaper').validate({
            rules: {name: {required: true},size: {required: true}
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalPaperEdit").modal("hide");//$("tbody#tblCompany").html(data);
                $("#myProcess").modal("show")
                $.ajax({url: '{{url()}}/settings/paperedit/'+id,type: 'post',data: $(form).serialize(),dataType: 'html',
                    success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });


        var validator = $('#regJob').validate({
            rules: {name: {required: true}
            },messages:{},
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalJobNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });

        var validator = $('#regPrice').validate({
            rules: {price: {required: true},job_type:{required : true},paperid:{required:true},jobid:{required:true},jobtype:{required:true}
            },messages:{},
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalPriceNew").modal("hide")
                p.modal("show")
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });

        var validator = $('#regPriceEdit').validate({
            rules: {_price: {required: true},_jobtype:{required: true},_paperid:{required: true}
            },messages: {
                _paperid: "Please select account type"},highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalPriceEdit").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '{{url()}}/settings/priceedit/'+id,type: 'post',data: $(form).serialize(),dataType: 'html',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
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

        $(".changestackstatus").each(function(){
            var e = $(this)

            alert("All Good")
            e.on("change",function(){
                alert("All Good")
                var status = $(this).val()
                var e, u, n, s;
                u="{{url()}}"+ e.attr("url");
                p.modal("show")
                $.ajax({url: u,type: 'post',data: {_token: $('meta[name="csrf_token"]').attr('content'),mstatus:status},dataType: 'html',
                success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000)}});

            })
        })


        $(".edtRoleLink").each(function(){
            var e = $(this)
            $(this).click(function(){
                var cid,cdescription,cname,clevel,cid = e.attr('cid');id = cid
                $("#id").val(e.attr('cid')); $("#_name").val(e.attr('cname'));$("#_description").val(e.attr('cdescription'));$("#_level").val(e.attr('clevel'));
                $('#myModalRoleEdit').modal("show")
            })
        })


        $(".edtPaperLink").each(function(){
            var e = $(this)
            $(this).click(function(){
                var cid,cname,c,cjobtype,cprice,cid = e.attr('cid');id = cid
                $("#id").val(e.attr('cid')); $("#_name").val(e.attr('cname'));$("#_description").val(e.attr('cdescription'));$("#_unit").val(e.attr('cunit')),$("#_size").val(e.attr('csize')),$("#_dimension").val(e.attr('cdimension'));
                $('#myModalPaperEdit').modal("show")
            })
        })

        $(".edtPriceLink").each(function(){
            var e = $(this)
            $(this).click(function(){
                var cid,cpaperid,cjobid,cjobtype,cprice,cid = e.attr('cid');id = cid
                $("#id").val(e.attr('cid')); $("#_paperid").val(e.attr('cpaperid'));$("#_jobid").val(e.attr('cjobid'));$("#_jobtype").val(e.attr('cjobtype'));
                $("#_price").val(e.attr('cprice'))
                $('#myModalPriceEdit').modal("show")
            })
        })

        $(".delLink").each(function(){
            var e, u, n, s;
            e = $(this),u= e.attr("url"),n= e.attr("dname");s="You are about to delete <b>"+n+"</b> from the record base! <br> Click Delete to procees!";e.click(function(){$("#myDelete div.delInfo").html(s);l.attr("href","{{url()}}"+u);d.modal("show");})
        })

        var validator = $('#edtFrmCompany').validate({
            rules: {email:{required: true},name: {required: true},address: {required: true},phone: {required: true}
            }, highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalComapanyEdit").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '<?php echo url() ?>/company/companyupdate/'+id,type: 'post',data: $(form).serialize(),dataType: 'html',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });
//module to delete any type of record via ajax
        l.on("click",function(){
            var u = $(this).attr("href");
            $("#myDelete").modal("hide")
            p.modal("show")
            $.ajax({url: u,type: 'post',data: {_token: $('meta[name="csrf_token"]').attr('content')},dataType: 'html',
                success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000)}});
            return false
        })

        var validator = $('#delFrmCompany').validate({
            rules: {email:{required: true},name: {required: true},address: {required: true},phone: {required: true}
            }, highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },submitHandler: function(form) {
                $("#myModalComapanyEdit").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '<?php echo url() ?>/company/companydelete/'+id,type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("tbody#tblCompany").html(data);$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });
        $("#reservation").on("focusin",function(){
            $(".ui-datepicker").css("z-index","100000 !important");
        })


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