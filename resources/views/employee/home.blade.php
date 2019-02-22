@extends('layouts.app')

@section('content')    
    <?php
        $w1Total = 0;
        $w2Total = 0;
        
        if ($timesheet != null) {
            $date = $timesheet->startDate;
        }
        function getDateOffset($date, $offset) {
            $date = strtotime($date) + ($offset * 86400);
            return date('m/d/y', $date);
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
                <button class="btn btn-success" data-toggle="modal" data-target="#newShift">New Shift</button>
                <div id="newShift" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="post" action="{{route('newShift')}}" onsubmit="return nsIsValid()">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">New Shift</h4>
                                </div>
                                <div class="modal-body">
                                    {{ csrf_field()}}
                                    <span class="text-danger" id="nsError"></span>
                                    <input type="hidden" name="timesheetId" value="{{$timesheet->id}}">
                                    <div class="form-group" id="nsDate">
                                        <label class="form-label">Date: </label><br>
                                        <input class="form-control" type="date" name="shiftDate" oninput="validateDateInput(this.value, '{{$timesheet->startDate}}')">
                                    </div>
                                    <div class="form-group" id="nsStart">
                                        <label class="form-label">Start Time: </label>
                                        <input class="form-control" type="time" name="shiftStart" oninput="startIsValid(this.value)">
                                    </div>
                                    <div class="form-group" id="nsEnd">
                                        <label class="form-label">End Time: </label>
                                        <input class="form-control" type="time" name="shiftEnd" oninput="endIsValid(this.value)">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Description: </label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success disabled" id="submitNewShift">Save</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
                            <td class="center">{{getDateOffset($date, $i)}}</td>
                        @endfor
                        <td></td>
                    </tr>
                    <tr>
                        @for($i = 0; $i < 7; $i ++)
                            <?php
                                if (isset($shifts)){
                                    $sArray = findShifts(getDateOffset($date, $i), $shifts);
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
                                        <button class="btn btn-info height-margin-1" data-toggle="modal" data-target="#{{$s->id}}">
                                            {{getShiftTimes($s)}}
                                        </button>
                                        <div id="{{$s->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="{{route('editShift')}}">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Edit Shift</h4>
                                                        </div>
                                                        <div class="modal-body left">
                                                            {{ csrf_field()}}
                                                            <input type="hidden" name="shiftId" value="{{$s->id}}">
                                                            <input type="hidden" name="date" value="{{$s->date}}">
                                                            <div class="form-group" id="esStart">
                                                                <label class="form-label">Start Time: </label>
                                                                <input class="form-control" type="time" name="shiftStart" value="{{$s->start}}">
                                                            </div>
                                                            <div class="form-group" id="esEnd">
                                                                <label class="form-label">End Time: </label>
                                                                <input class="form-control" type="time" name="shiftEnd" value="{{$s->end}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Description: </label>
                                                                <textarea class="form-control" name="description">{{$s->description}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    @endforeach
                                @endif
                            </td>
                        @endfor
                        <td class="center">{{$w1Total}}</td>
                    </tr>
                    <tr class="active">
                        @for($i = 7; $i < 14; $i ++)
                            <td class="center">{{getDateOffset($date, $i)}}</td>
                        @endfor
                        <td class="center"></td>
                    </tr>
                    <tr>
                        @for($i = 7; $i < 14; $i ++)
                            <?php
                                if (isset($shifts)){
                                    $sArray = findShifts(getDateOffset($date, $i), $shifts);
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
                                        <button class="btn btn-info height-margin-1" data-toggle="modal" data-target="#{{$s->id}}">
                                            {{getShiftTimes($s)}}
                                        </button>
                                        <div id="{{$s->id}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="{{route('editShift')}}">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Edit Shift</h4>
                                                        </div>
                                                        <div class="modal-body left">
                                                            {{ csrf_field()}}
                                                            <input type="hidden" name="shiftId" value="{{$s->id}}">
                                                            <input type="hidden" name="date" value="{{$s->date}}">
                                                            <div class="form-group" id="esStart">
                                                                <label class="form-label">Start Time: </label>
                                                                <input class="form-control" type="time" name="shiftStart" value="{{$s->start}}">
                                                            </div>
                                                            <div class="form-group" id="esEnd">
                                                                <label class="form-label">End Time: </label>
                                                                <input class="form-control" type="time" name="shiftEnd" value="{{$s->end}}">
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Description: </label>
                                                                <textarea class="form-control" name="description">{{$s->description}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Save</button>
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    @endforeach
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

    <script src={{asset('js/validators.js')}}></script>
@endsection