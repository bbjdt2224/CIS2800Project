@extends('layouts.app')

@section('content')
    <?php
        $w1Total = 0;
        $w2Total = 0;
        
        if ($timesheet != null) {
            $startDate = $timesheet->startDate;
        }
        function getDateOffset($date, $offset) {
            return strtotime($date) + ($offset * 86400);
        }

        function getDateId($date, $offset) {
            $date = getDateOffset($date, $offset);
            return str_replace('/', '', $date);
        }

        function findShifts($date, $shifts){
            if (isset($shifts)) {
                $sArray = [];
                foreach($shifts as $s) {
                    if (strtotime($s->date) == $date){
                        if($s->start < 12){
                            $sArray[0] = $s;
                        }
                        else if ($s->start < 17) {
                            $sArray[1] = $s;
                        }
                        else {
                            $sArray[2] = $s;
                        }
                    }
                }
                return $sArray;
            }
        }

        function getStartTime($shift) {
            return date('g:i a', strtotime($shift->start));
        }

        function getEndTime($shift) {
            return date('g:i a', strtotime($shift->end));
        }

        function getIndex($user, $userList) {
            for($i = 0; $i < count($userList); $i ++) {
                if ($user->id == $userList[$i]->userId){
                    return $i + 1;
                }
            }
            return 0;
        }

        function getTimesheetId($user, $userList){
            return $userList[$user]->id;
        }

        $userIndex = getIndex($user, $userList);

    ?>
    <div class="container-fluid" id="printPage">
        <div class="timesheet-buttons">
            <a href="{{$back}}" class="btn btn-primary" id="backButton">
                <span class="glyphicon glyphicon-menu-left"></span>
                Back
            </a>
            <div id="buttons">
                @if($timesheet->status == 'submitted')
                    <button class="btn btn-success width-margin-1" onclick="document.getElementById('approveForm').submit()">Approve</button>
                    <button class="btn btn-danger width-margin-1" data-toggle="modal" data-target="#rejectModal">Reject</button>
                @elseif($timesheet->status == 'approved')
                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>  Approved</span>
                @elseif($timesheet->status == 'rejected')
                    <span class="text-danger"><span class="glyphicon glyphicon-warning-sign"></span>  Rejected</span>
                @else
                    <span class="text-warning"><span class="glyphicon glyphicon-refresh"></span>  In Progress</span>
                @endif
                <a href="{{route('viewTimesheet', ['timesheetId' => $timesheet->id, 'back'=>$back])}}" class="btn btn-primary width-margin-1" onclick="removeButtons(); window.print();" >Print</a>
            </div>
        </div>
        <div class="timesheet-headers">
            <h4 class="width-margin-2">{{$user->name}}</h4>
            @foreach($headers as $h)
                <h4 class="width-margin-2">{{$h->header}}</h4>
            @endforeach
        </div>
		<table class='table table-condensed'>
			<thead class="center">
				<th>Day</th>
                <th>Date</th>
                <th>Morning Begin</th>
                <th>Morning End</th>
                <th>Afternoon Begin</th>
                <th>Afternoon End</th>
                <th>Evening Begin</th>
                <th>Evening End</th>
                <th></th>
                <th>Total</th>
            </thead>
            <tbody class="center">
                @for($i = 0; $i < 7; $i ++)
                    <?php
                        $shiftArray = findShifts(getDateOffset($timesheet->startDate, $i), $shifts);
                        $total = 0;
                        foreach($shiftArray as $shift) {
                            $total += $shift->total;
                        }
                        $w1Total += $total;
                    ?>
                    <tr>
                        <td>{{date('l', getDateOffset($timesheet->startDate, $i))}}</td>
                        <td>{{date('m/d/y', getDateOffset($timesheet->startDate, $i))}}</td>
                        @if (isset($shiftArray[0]))
                            <td>{{getStartTime($shiftArray[0])}}</td>
                            <td>{{getEndTime($shiftArray[0])}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        @if (isset($shiftArray[1]))
                            <td>{{getStartTime($shiftArray[1])}}</td>
                            <td>{{getEndTime($shiftArray[1])}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        @if (isset($shiftArray[2]))
                            <td>{{getStartTime($shiftArray[2])}}</td>
                            <td>{{getEndTime($shiftArray[2])}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td></td>
                        <td>{{$total}}</td>
                    </tr>   
                @endfor
                <tr>
                    <td colspan="8"></td>
                    <td>Week 1 Total</td>
                    <td>{{$w1Total}}</td>
                </tr>
                @for($i = 7; $i < 14; $i ++)
                    <?php
                        $shiftArray = findShifts(getDateOffset($timesheet->startDate, $i), $shifts);
                        $total = 0;
                        foreach($shiftArray as $shift) {
                            $total += $shift->total;
                        }
                        $w2Total += $total;
                    ?>
                    <tr>
                        <td>{{date('l', getDateOffset($timesheet->startDate, $i))}}</td>
                        <td>{{date('m/d/y', getDateOffset($timesheet->startDate, $i))}}</td>
                        @if (isset($shiftArray[0]))
                            <td>{{getStartTime($shiftArray[0])}}</td>
                            <td>{{getEndTime($shiftArray[0])}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        @if (isset($shiftArray[1]))
                            <td>{{getStartTime($shiftArray[1])}}</td>
                            <td>{{getEndTime($shiftArray[1])}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        @if (isset($shiftArray[2]))
                            <td>{{getStartTime($shiftArray[2])}}</td>
                            <td>{{getEndTime($shiftArray[2])}}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td></td>
                        <td>{{$total}}</td>
                    </tr>   
                @endfor
                <tr>
                    <td colspan="8"></td>
                    <td>Week 2 Total</td>
                    <td>{{$w2Total}}</td>
                </tr>
                <tr>
                    <td colspan="8"></td>
                    <td>Total</td>
                    <td>{{$w1Total + $w2Total}}</td>
                </tr>
            </tbody>
        </table>
        @if($timesheet->signature != null)
            <img width="300px" height="75px" src="{{$timesheet->signature}}">
        @else
           <h1>Unsubmitted</h1>
        @endif
        @if(strpos($back, 'home')>0)
            <div class="center-page" id="quickNav">
                @if($userIndex > 1)
                    <a href="{{route('viewTimesheet', ['timesheetId' => $userList[$userIndex-2], 'back'=>$back])}}" class="btn btn-primary">Prev</a>
                @else 
                    <a class="btn btn-primary disabled">Prev</a>
                @endif
                <span class="width-padding-1">{{$userIndex}} of {{sizeof($userList)}}</span>
                @if($userIndex < sizeof($userList))
                    <a href="{{route('viewTimesheet', ['timesheetId' => $userList[$userIndex], 'back'=>$back])}}" class="btn btn-primary">Next</a>
                @else
                    <a class="btn btn-primary disabled">Next</a>
                @endif
            </div>
        @endif
    </div>

    <form method="post" action="{{route('approveTimesheet')}}" id="approveForm">
        {{ csrf_field()}}
        <input type="hidden" name="timesheetId" value="{{$timesheet->id}}">
    </form>

    <div id="rejectModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="{{route('rejectTimesheet')}}" onsubmit="return validateForm(this)">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reject Timesheet</h4>
                    </div>
                    <div class="modal-body left">
                        {{ csrf_field()}}
                        <input type="hidden" name="timesheetId" value="{{$timesheet->id}}">
                        <h3>Why is this rejected?</h3>
                        <textarea class="form-control" name="notes" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Reject</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('js/helpers.js')}}"></script>
@endsection