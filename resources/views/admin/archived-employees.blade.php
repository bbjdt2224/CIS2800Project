@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li><a href="{{route('adminHome')}}">Current Timesheets</a></li>
            <li><a href="{{route('employees')}}">Employees</a></li>
            <li><a href="{{route('archivedTimesheets')}}">Archived Timesheets</a></li>
            <li class="active"><a href="#">Archived Employees</a></li>
        </ul>
        <ul class="list-group bottom-margin-10">
            @for($i = 0; $i < count($users); $i ++)
                <li class="list-group-item space-between">
                    <span class="min-width-300">{{$users[$i]->name}}</span>
                    <span class="width-400">{{$users[$i]->email}}</span>
                    <button class="btn btn-danger" onclick="document.getElementById('unarchive{{$i}}').submit();">Unarchive</button>
                </li>
                <form method="post" action="{{route('unarchiveEmployee')}}" id="unarchive{{$i}}">
                    {{ csrf_field()}}
                    <input type="hidden" name="employeeId" value="{{$users[$i]->id}}">
                </form>
            @endfor
        </ul>
    </div>
@endSection