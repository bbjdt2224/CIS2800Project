@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{route('employees')}}" class="btn btn-primary bottom-margin-1">
            <span class="glyphicon glyphicon-menu-left"></span>
            Employees
        </a>
        <div class="jumbotron">
            <h2>Edit Employee</h2>
        </div>
        <form method="post" action="{{route('employeeEdit')}}" class="space-between">
            {{ csrf_field()}}
            <input type="hidden" name="employeeId" value="{{$employee->id}}">
            <input type="text" name="name" value="{{$employee->name}}" class="form-control right-margin-1">
            <input type="text" name="email" value="{{$employee->email}}" class="form-control right-margin-1">
            <button type="submit" class="btn btn-success right-margin-1">Save</button>
            <button type="button" class="btn btn-primary right-margin-1">Change Password</button>
            <button type="button" class="btn btn-danger" onclick="document.getElementById('archive').submit();">Archive</button>
        </form>
    </div>

    <form method="post" action="{{route('archiveEmployee')}}" id="archive">
        {{ csrf_field()}}
        <input type="hidden" name="employeeId" value="{{$employee->id}}">
    </form>
@endsection