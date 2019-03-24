@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="space-between">
            <ul class="nav nav-tabs">
                <li><a href="{{route('adminHome')}}">Current Timesheets</a></li>
                <li class="active"><a href="#">Employees</a></li>
                <li><a href="{{route('archivedTimesheets')}}">Archived Timesheets</a></li>
                <li><a href="{{route('archivedEmployees')}}">Archived Employees</a></li>
            </ul>
            <button class="btn btn-success" data-toggle="modal" data-target="#new-employee">New Employee</button>
            <div id="new-employee" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" action="{{route('createEmployee')}}">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">New Employee</h4>
                            </div>
                            <div class="modal-body left">
                                {{ csrf_field()}}
                                <div class="form-group">
                                    <label>Name:</label>
                                    <input type="text" class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="space-between">
                                    <span>Timesheet Headers</span>
                                    <button type="button" class="btn btn-success" onclick="addHeader()"><span class="glyphicon glyphicon-plus"></span></button>
                                </div>
                                <div id="headers">
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
            @for($i = 0; $i < count($employees); $i ++)
                <?php
                    $message = "Your admin has requested a password change for you account. Click on the following link to change your password%0D%0A%0D%0Ahttp://localhost/2800/Project/public/changePassword/".$employees[$i]->password_token.'%0D%0A%0D%0A WMU Timesheets';
                ?>
                <li class="list-group-item space-between">
                    <button class="min-width-300 btn btn-link left" data-toggle="modal" data-target="#edit{{$i}}" onclick="loadHeaders({{$employees[$i]->id}})">
                        {{$employees[$i]->name}}
                    </button>
                    <span class="width-400">{{$employees[$i]->email}}</span>
                    <button class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                </li>
                <div id="edit{{$i}}" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="{{route('employeeEdit')}}">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Edit Employee</h4>
                                </div>
                                <div class="modal-body left">
                                    {{ csrf_field()}}
                                    <input type="hidden" name="employeeId" value="{{$employees[$i]->id}}">
                                    <div class="form-group">
                                        <label>Name:</label>
                                        <input type="text" class="form-control" name="name" value="{{$employees[$i]->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label>Email:</label>
                                        <input type="text" class="form-control" name="email" value="{{$employees[$i]->email}}">
                                    </div>
                                    <div class="space-between">
                                        <span>Timesheet Headers</span>
                                        <button type="button" class="btn btn-success" onclick="addHeader({{$employees[$i]->id}})"><span class="glyphicon glyphicon-plus"></span></button>
                                    </div>
                                        <div id="headers{{$employees[$i]->id}}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success right-margin-1">Save</button>
                                    <a href="mailto:{{$employees[$i]->email}}?subject=Change Password&body={{$message}}" class="btn btn-primary right-margin-1">Change Password</a>
                                    <button type="button" class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form method="post" action="{{route('archiveEmployee')}}" id="archive{{$i}}">
                    {{ csrf_field()}}
                    <input type="hidden" name="employeeId" value="{{$employees[$i]->id}}">
                </form>
            @endfor
        </ul>
    </div>
    <script>
        function addHeader(id) {
            if (id == undefined) {
                var list = document.getElementById('headers');
            }
            else {
                var list = document.getElementById('headers'+id);
            }
            var header = document.createElement('div');
            header.classList.add('space-between');
            header.classList.add('height-margin-1');
            header.innerHTML = '<input type="text" class="form-control right-margin-1" name="headers[]"><button type="button" class="btn btn-danger" onclick="removeHeader(this, null)"><span class="glyphicon glyphicon-minus"></span></button>';
            list.appendChild(header);
        }

        function removeHeader(element, id) {
            element.parentElement.parentElement.removeChild(element.parentElement);
            if (id != null) {
                $.ajax({ 
                    headers: {
                        'X-CSRF-TOKEN': $("input[name=_token]").val()
                    }, 
                    url:"{{route('removeHeader')}}",  
                    method:"POST",  
                    data:{id:id},                              
                    success: function( data ) {
                    }
                });
            }
        }

        function loadHeaders(id){
            $.ajax({ 
                headers: {
                    'X-CSRF-TOKEN': $("input[name=_token]").val()
                }, 
                url:"{{route('getHeaders')}}",  
                method:"POST",  
                data:{id:id},                              
                success: function( data ) {
                    var list = document.getElementById('headers'+id);
                    if (list.childNodes.length <= 1) {
                        for(var i = 0; i < data.length; i++) {
                            var h = document.createElement('div');
                            h.classList.add('space-between');
                            h.classList.add('height-margin-1');
                            h.innerHTML = '<input type="text" class="form-control right-margin-1" name="headers[]" value="'+data[i].header+'">'
                            +'<input type="hidden" name="headerId[]" value="'+data[i].id+'">'
                            +'<button type="button" class="btn btn-danger" onclick="removeHeader(this, '+data[i].id+')"><span class="glyphicon glyphicon-minus"></span></button>';
                            list.appendChild(h);
                        }
                    }
                }
            });
        }

        function changePassword(email, token) {
            window.location.href = 'mailto:'+email+'?subject=Change Password';
        }
    </script>
@endsection
