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
    ?>
    <div class="container-fluid" id="printPage">
        <div class="timesheet-buttons">
            <a href="{{route('viewTimesheet', ['userId' => $user->id])}}"><button class="btn btn-primary width-margin-1" onclick="removeButtons(); window.print();" id="printButton">Print</button></a>
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
                        <td>{{$total}}</td>
                    </tr>   
                @endfor
                <tr>
                    <td colspan="7"></td>
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
                        <td>{{$total}}</td>
                    </tr>   
                @endfor
                <tr>
                    <td colspan="7"></td>
                    <td>Week 2 Total</td>
                    <td>{{$w2Total}}</td>
                </tr>
                <tr>
                    <td colspan="7"></td>
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
    </div>

    <script src="{{asset('js/helpers.js')}}"></script>
@endsection