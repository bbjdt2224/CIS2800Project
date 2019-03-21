@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li><a href="{{route('superadminHome')}}">Organizations</a></li>
            <li class="active"><a href="#">All Users</a></li>
        </ul>
        <ul class="list-group bottom-margin-10">
            @for($i = 0; $i < count($users); $i ++)
                <?php
                    $message = "Your admin has requested a password change for you account. Click on the following link to change your password%0D%0A%0D%0Ahttp://localhost/2800/Project/public/changePassword/".$users[$i]->password_token.'%0D%0A%0D%0A WMU Timesheets';
                ?>
                <li class="list-group-item space-between">
                    <button class="min-width-300 btn btn-link left" data-toggle="modal" data-target="#edit{{$i}}">
                        {{$users[$i]->name}}
                    </button>
                    <span class="width-400">{{$users[$i]->email}}</span>
                    <span class="width-400">{{ucfirst($users[$i]->role)}}</span>
                    <span class="width-400">{{$users[$i]->title}}</span>
                    <button class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                </li>
                <div id="edit{{$i}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="{{route('editUser')}}">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Employee</h4>
                                </div>
                                <div class="modal-body left">
                                    {{ csrf_field()}}
                                    <input type="hidden" name="userId" value="{{$users[$i]->id}}">
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input type="text" class="form-control" name="name" value="{{$users[$i]->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" name="email" value="{{$users[$i]->email}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success right-margin-1">Save</button>
                                    <a href="mailto:{{$users[$i]->email}}?subject=Change Password&body={{$message}}" class="btn btn-primary right-margin-1">Change Password</a>
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{route('archiveEmployee')}}" id="archive{{$i}}">
                    {{ csrf_field()}}
                    <input type="hidden" name="employeeId" value="{{$users[$i]->id}}">
                </form>
            @endfor
        </ul>
    </div>
@endsection
