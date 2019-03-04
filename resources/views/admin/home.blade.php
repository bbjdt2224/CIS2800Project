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
        <table class="table">
            <thead>
                <th>Name</th>
                <th class="center">Hours</th>
                <th class="center">Current Timesheet</th>
                <th>Status</th>
            </thead>
            <tbody>
                @foreach($users as $u)
                    <tr>
                        <td>{{$u->name}}</td>
                        @if($u->startDate == $date)
                            <td class="center">{{$u->total}}</td>
                            <td class="center"><a class="btn btn-primary" href="{{route('viewTimesheet', ['timesheetId' => $u->id])}}">View</a></td>
                        @else
                            <td class="center">-</td>
                            <td class="center"><a class="btn btn-primary disabled" href="{{route('viewTimesheet', ['timesheetId' => $u->id])}}">View</a></td>
                        @endif
                        <td>
                            @if($u->startDate == $date)
                                @if($u->status == 'submitted')
                                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>  Submitted</span>
                                @elseif($u->status == 'approved')
                                    <span class="text-success"><span class="glyphicon glyphicon-ok"></span>  Approved</span>
                                @elseif($u->status == 'rejected')
                                    <span class="text-danger"><span class="glyphicon glyphicon-warning-sign"></span>  Rejected</span>
                                @else
                                    <span class="text-warning"><span class="glyphicon glyphicon-refresh"></span>  In Progress</span>
                                @endif
                            @else
                                <span class="text-danger"><span class="glyphicon glyphicon-remove"></span>  Not Started</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection