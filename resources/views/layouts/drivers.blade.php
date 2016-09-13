<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 1/15/2016
 * Time: 6:25 AM
 */?>
<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/11/15
 * Time: 7:39 PM
 */

?>


        <!DOCTYPE html>
<html>
<head>
    @include("includes.head")
            <!--<link rel="stylesheet" href="{{url()}}/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="{{url()}}/plugins/daterangepicker/daterangepicker-bs3.css">-->
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
                <small></small>
            </h1>
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

<!--<script src="{{url()}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url()}}/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="{{url()}}/plugins/datatables/dataTables.bootstrap.min.js"></script>-->

<script src="{{url()}}/dist/js/app.min.js"></script>
<script src="{{url()}}/dist/js/jquery.validate.min.js"></script>
<script src="{{url()}}/dist/js/jquery.form.min.js"></script>

<script>


    $(function () {

        var l, p,id;// l for delete link;;;; p for the progress bar modal;;; id set for update and delete ajax url for get and post
        var d=$(".myDelete");l=$("a.del");p=$("#myProcess")
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        $('#reservation').datepicker(
                {
                    dateFormat: 'yy-mm-dd',
                    changeMonth: true
                }
        ).datepicker("setDate", new Date());
        /**
         * This section is the ajax form validated and submitted to
         * create company from the conpany listing/index page
         */
        var validator = $('#regCompany').validate({
            rules: {
                email: {
                    required: true
                },
                name: {
                    required: true
                }
            },submitHandler: function(form) {
                $("#myModalComapanyNew").modal("hide")
                $("#myProcess").modal("show")
                $.ajax({url: '',type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
            }
        });


        $(".changestackstatus").each(function(){
            var e, u, n, s;
            e = $(this)
            u="{{url()}}"+ e.attr("url");
            e.on("change",function(){
                var status = $(this).val()
                p.modal("show")
                $.ajax({url: u,type: 'post',data: {_token: $('meta[name="csrf_token"]').attr('content'),mstatus:status},dataType: 'html',
                    success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000)}});

            })
        })


        /**
         * This section is the ajax form validated and submitted to
         * update branch/site info from the companydetail
         */

        var validator = $('#edtFrmBranch').validate({
            rules: {email:{required: true},company_id: {required: true},name: {required: true},address: {required: true},phone: {required: true}
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
                $("#myModalBranchEdit").modal("hide")
                $("#myProcess").modal("show")//$("tbody#tblCompany").html(data);
                $.ajax({url: '<?php echo url() ?>/company/branchupdate/'+id,type: 'post',data: $(form).serialize(),dataType: 'json',
                    success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000);}});
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

        $("#reservation").on("focusin",function(){
            $(".ui-datepicker").css("z-index","100000 !important");
        })

        $(".delLink").each(function(){
            var e, u, n, s;
            e = $(this),u= e.attr("url"),n= e.attr("dname");s="You are about to delete <b>"+n+"</b> from the record base! <br> Click Delete to procees!";e.click(function(){$("#myDelete div.delInfo").html(s);l.attr("href","{{url()}}"+u);d.modal("show");})
        })
        //module to delete any type of record via ajax
        l.on("click",function(){
            var u = $(this).attr("href");
            $("#myDelete").modal("hide")
            p.modal("show")
            $.ajax({url: u,type: 'post',data: {_token: $('meta[name="csrf_token"]').attr('content')},dataType: 'html',
                success:function(data){if(data){$("div#transProcess").html("<div class='alert alert-info fade in'><button class='close' data-dismiss='alert'>×</button><i class='fa-fw fa fa-check'></i>"+data+"</div>")}else{alert(data);}setInterval(window.location.reload(),500000)}});
            return false
        })


        $('#issue_date').datepicker(
                {
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 3,
                    onClose: function( selectedDate ) {
                        $( "#expiry_date" ).datepicker( "option", "minDate", selectedDate );
                    }
                }
        );


        $('#expiry_date').datepicker(
                {
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 3,
                    onClose: function( selectedDate ) {
                        $( "#issue_date" ).datepicker( "option", "maxDate", selectedDate );
                    }
                }
        );

    });
</script>
<!--<script>
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
</script>-->
</body>
</html>
