@extends('layouts.app')

@section('content')    
    <?php
        $w1Total = 0;
        $w2Total = 0;
        
        if ($timesheet != null) {
            $startDate = $timesheet->startDate;
        }
        function getDateOffset($date, $offset) {
            $date = strtotime($date) + ($offset * 86400);
            return date('m/d/y', $date);
        }

        function getDateId($date, $offset) {
            $date = getDateOffset($date, $offset);
            return str_replace('/', '', $date);
        }

        function findShifts($date, $shifts){
            if (isset($shifts)) {
                $sArray = [];
                foreach($shifts as $s) {
                    if (strtotime($s->date) == strtotime($date)){
                        array_push($sArray, $s);
                    }
                }
                return $sArray;
            }
        }

        function getShiftTimes($shift) {
            return date('g:i a', strtotime($shift->start)).' - '.date('g:i a', strtotime($shift->end));
        }
        function compareShifts($a, $b) {
            return strcmp($a->start, $b->start);
        }
        function isEditable($timesheet){
            $date = date('W', time());
            if($date%2 != 1){
                $date = $date -1;
            }
            $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));
            if($timesheet->status == 'progress' && $date == $timesheet->startDate) {
                return true;
            }
            return false;
        }
    ?>
    <div class="container">
        @if(isset($timesheet))
            <div class="space-between height-margin-4">
                <form class="form-inline" method="post" action="{{route('pastTimesheet')}}">
                    {{ csrf_field()}}
                    <div class="form-group">
                        <input type="date" class="form-control" name="date">
                    </div>
                    <button type="submit" class="btn btn-success">Change Date</button>
                </form>
                @if(isEditable($timesheet))
                    <form method="post" action="{{route('sign')}}">
                        {{ csrf_field()}}
                        <input type="hidden" value="{{$timesheet->id}}" name="timesheetId">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                @endif
            </div>
            <table class="table">
                <thead>
                    <th class="center">Monday</th>
                    <th class="center">Tuesday</th>
                    <th class="center">Wednesday</th>
                    <th class="center">Thursday</th>
                    <th class="center">Friday</th>
                    <th class="center">Saturday</th>
                    <th class="center">Sunday</th>
                    <th class="center">Total</th>
                </thead>
                <tbody>
                    <tr class="active">
                        @for($i = 0; $i < 7; $i ++)
                            <td class="center">{{getDateOffset($startDate, $i)}}</td>
                        @endfor
                        <td></td>
                    </tr>
                    <tr>
                        @for($i = 0; $i < 7; $i ++)
                            <?php
                                if (isset($shifts)){
                                    $sArray = findShifts(getDateOffset($startDate, $i), $shifts);
                                    usort($sArray, "compareShifts");
                                    if (isset($sArray)) {
                                        foreach($sArray as $s){
                                            $w1Total += $s->total;
                                        }
                                    }
                                }
                            ?>
                            <td class="center">
                                @if(isset($sArray))
                                    @foreach($sArray as $s)
                                        @if(isEditable($timesheet))
                                            <button class="btn btn-info height-margin-1" data-toggle="modal" data-target="#{{$s->id}}">
                                                {{getShiftTimes($s)}}
                                            </button>
                                            @include('employee.modals', [$shift = $s])
                                            <br>
                                        @else
                                            <span class="shiftText">{{getShiftTimes($s)}}</span>
                                        @endif
                                    @endforeach
                                @endif
                                @if(isEditable($timesheet) && (isset($sArray) && count($sArray) < 3))
                                    <button class="btn btn-primary height-margin-1" data-toggle="modal" data-target="#{{getDateId($startDate, $i)}}">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                    @include('employee.new-shift', [$dateId = getDateId($startDate, $i), $date = getDateOffset($startDate, $i)])
                                @endif
                            </td>
                        @endfor
                        <td class="center">{{$w1Total}}</td>
                    </tr>
                    <tr class="active">
                        @for($i = 7; $i < 14; $i ++)
                            <td class="center">{{getDateOffset($startDate, $i)}}</td>
                        @endfor
                        <td class="center"></td>
                    </tr>
                    <tr>
                        @for($i = 7; $i < 14; $i ++)
                            <?php
                                if (isset($shifts)){
                                    $sArray = findShifts(getDateOffset($startDate, $i), $shifts);
                                    if (isset($sArray)) {
                                        foreach($sArray as $s){
                                            $w2Total += $s->total;
                                        }
                                    }
                                }
                            ?>
                            <td class="center">
                                @if(isset($s))
                                    @foreach($sArray as $s)
                                        @if(isEditable($timesheet))
                                            <button class="btn btn-info height-margin-1" data-toggle="modal" data-target="#{{$s->id}}">
                                                {{getShiftTimes($s)}}
                                            </button>
                                            @include('employee.modals', [$shift = $s])
                                            <br>
                                        @else
                                            <span class="shiftText">{{getShiftTimes($s)}}</span>
                                        @endif
                                    @endforeach
                                @endif
                                @if(isEditable($timesheet) && (isset($sArray) && count($sArray) < 3))
                                    <button class="btn btn-primary height-margin-1" data-toggle="modal" data-target="#{{getDateId($date, $i)}}">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                    @include('employee.new-shift', [$dateId = getDateId($date, $i), $date = getDateOffset($startDate, $i)])
                                @endif
                            </td>
                        @endfor
                        <td class="center">{{$w2Total}}</td>
                    </tr>
                    <tr>
                        <td colspan="7"></td>
                        <td class="center">{{$w1Total+$w2Total}}</td>
                </tbody>
            </table>
        @else
            <form class="form-inline height-margin-4" method="post" action="{{route('pastTimesheet')}}">
                {{ csrf_field()}}
                <div class="form-group">
                    <input type="date" class="form-control" name="date">
                </div>
                <button type="submit" class="btn btn-success">Change Date</button>
            </form>
            <div class="jumbotron">
                <h1 class="center">You do not have a time sheet this time period</h1>
            </div>
        @endif
    </div>

    <script src="{{asset('js/validation.js')}}"></script>
@endsection