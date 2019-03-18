@extends('layouts.app')

@section('content')
<div class="container">
        <div class="space-between bottom-margin-1">
            <span></span>
            <button class="btn btn-success" data-toggle="modal" data-target="#new-organization">New Organization</button>
            <div id="new-organization" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{route('createOrganization')}}">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">New Organization</h4>
                            </div>
                            <div class="modal-body left">
                                {{ csrf_field()}}
                                <div class="form-group">
                                    <label>Admin Name:</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Admin Email:</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label>Organization Name:</label>
                                    <input type="text" class="form-control" name="orgName">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <ul class="list-group bottom-margin-10">
            @for($i = 0; $i < count($admins); $i ++)
                <li class="list-group-item space-between">
                    <button class="min-width-300 btn btn-link left" data-toggle="modal" data-target="#edit{{$i}}" onclick="loadHeaders({{$admins[$i]->id}})">
                        {{$admins[$i]->name}}
                    </button>
                    <span class="width-400">{{$admins[$i]->email}}</span>
                    <span class="width-400">{{$admins[$i]->title}}</span>
                    <span class="width-400">{{$admins[$i]->members}} Members</span>
                    <button class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                </li>
                <div id="edit{{$i}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="{{route('editOrganization')}}">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Organization</h4>
                                </div>
                                <div class="modal-body left">
                                    {{ csrf_field()}}
                                    <input type="hidden" name="userId" value="{{$admins[$i]->id}}">
                                    <input type="hidden" name="orgId" value="{{$admins[$i]->organizationId}}">
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input type="text" class="form-control" name="name" value="{{$admins[$i]->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" name="email" value="{{$admins[$i]->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Organization Name:</label>
                                        <input type="text" class="form-control" name="orgName" value="{{$admins[$i]->title}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success right-margin-1">Save</button>
                                    <button type="button" class="btn btn-primary right-margin-1">Change Password</button>
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('archive').submit();">Archive</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{route('archiveOrganization')}}" id="archive{{$i}}">
                    {{ csrf_field()}}
                    <input type="hidden" name="employeeId" value="{{$admins[$i]->id}}">
                </form>
            @endfor
        </ul>
    </div>
@endsection