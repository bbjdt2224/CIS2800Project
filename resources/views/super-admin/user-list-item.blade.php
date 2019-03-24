<?php
    $message = "Your admin has requested a password change for you account. Click on the following link to change your password%0D%0A%0D%0Ahttp://localhost/2800/Project/public/changePassword/".$user->password_token.'%0D%0A%0D%0A WMU Timesheets';
?>
<li class="list-group-item space-between" id="{{$user->id}}">
    <button class="min-width-300 btn btn-link left" data-toggle="modal" data-target="#edit{{$i}}">
        {{$user->name}}
    </button>
    <span class="width-400">{{$user->email}}</span>
    <span class="width-400">{{ucfirst($user->role)}}</span>
    <span class="width-400">{{$user->title}}</span>
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
                    <input type="hidden" name="userId" value="{{$user->id}}">
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" class="form-control" name="name" value="{{$user->name}}">
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="text" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success right-margin-1">Save</button>
                    <a href="mailto:{{$user->email}}?subject=Change Password&body={{$message}}" class="btn btn-primary right-margin-1">Change Password</a>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                </div>
            </form>
        </div>
    </div>
</div>
<form method="post" action="{{route('archiveEmployee')}}" id="archive{{$i}}">
    {{ csrf_field()}}
    <input type="hidden" name="employeeId" value="{{$user->id}}">
</form>