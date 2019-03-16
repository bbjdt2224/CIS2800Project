@extends('layouts.app')

@section('content')
    <?php
        $date = date('W', time());
        if($date%2 != 1){
            $date = $date -1;
        }
        $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));

    ?>
    <div class="container">
        <ul class="nav nav-tabs">
            <li><a href="{{route('adminHome')}}">Current Timesheets</a></li>
            <li class="active"><a href="#">Employees</a></li>
            <li><a href="{{route('archivedTimesheets')}}">Archived Timesheets</a></li>
            <li><a href="{{route('archivedEmployees')}}">Archived Employees</a></li>
        </ul>
        <ul class="list-group bottom-margin-10">
            @for($i = 0; $i < count($employees); $i ++)
                <li class="list-group-item space-between">
                    <a class="min-width-300" href="{{route('editEmployee', ['employeeId' => $employees[$i]->id])}}">
                        <span>{{$employees[$i]->name}}</span>
                    </a>
                    <span class="width-400">{{$employees[$i]->email}}</span>
                    <button class="btn btn-danger" onclick="document.getElementById('archive{{$i}}').submit();">Archive</button>
                </li>
                <form method="post" action="{{route('archiveEmployee')}}" id="archive{{$i}}">
                    {{ csrf_field()}}
                    <input type="hidden" name="employeeId" value="{{$employees[$i]->id}}">
                </form>
            @endfor
        </ul>
    </div>
@endsection
