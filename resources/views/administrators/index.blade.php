<?php
/**
 * Created by PhpStorm.
 * User: Amedora
 * Date: 10/13/15
 * Time: 12:08 PM
 */ ?>
@extends("layouts.tablelayout")
@section("content")



<div class="row">
    <div class="col-lg-2 pull-right">
        <a href="{{url()}}/administrators/addnew" class="btn btn-block btn-primary">Add New Company</a>
    </div>
</div>



<div class="box">
    <div class="box-header">
        <h3 class="box-title"></h3>
    </div><!-- /.box-header -->
    <div class="box-body">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>Sn</th>
                <th>Full name</th>
                <th>email</th>
                <th>username</th>
                <th>Telephone</th>

                <th>Date Added</th>
                <th>Action</th>
                <th>s</th>
            </tr>
            </thead>
            <tbody id="tblCompany">
            {{--*/ $x = 1 /*--}}
            @foreach($users as $user)
            <tr>
                <td>{{$x }}</td>
                <td>{{$user->firstname}} {{$user->lastname}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->phone}}</td>

                <td>{{$user->created_at}}</td>

                <td></td>
                <td><a href="#" data-toggle="modal" data-target="#myModal{{$user->id}}"><i class="fa fa-trash">Delete</a></i> <!-- Modal -->
                    <div class='modal fade' id='myModal{{$user->id}}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header  ' style="background-color: #3276B1; color:#fff">
                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>
                                        &times;
                                    </button>
                                    <h1 class='modal-title' id='myModalLabel'>Remove User</h1>
                                </div>
                                <div class='modal-body' id="mbody{{$user->id}}">

                                    <div class='row' >
                                        <div class='col-md-12'>

                                            <input type="hidden" id="pgid{{$user->id}}" name="pgid" value="{{$user->id}}">

                                            <h2>Are you sure you want to remove <b>{{$user->firstname}}</b> from the database ?</h2>
                                        </div>
                                    </div>


                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>
                                        Cancel
                                    </button>
                                    <button type='button' class='btn btn-primary datadel' dal="{{$user->id}}">
                                        Delete
                                    </button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </td>
            </tr>
            {{--*/ $x++ /*--}}
            @endforeach
            </tbody>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

@stop




