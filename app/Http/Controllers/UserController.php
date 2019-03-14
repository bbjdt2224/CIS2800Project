<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Timesheet;
use App\Shift;
use App\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('employee');
        // $this->middleware('admin');
    }

    public function employeeHome() {
        
        $date = date('W', time());
        if($date%2 != 1){
            $date = $date -1;
        }
        $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));

        $timesheet = Timesheet::where('userId', '=', Auth::id())->where('startdate', '=', $date)->first();

        if ($timesheet != null) {
            $shifts = Shift::where('timesheetId', '=', $timesheet->id)->get();
            return view('employee.home', compact('timesheet', 'shifts'));
        }
        else {
            $timesheet = Timesheet::create([
                'userId' => Auth::id(),
                'startDate' => $date,
                'status' => 'progress',
                'total' => 0
            ]);
            User::find(Auth::id())->update(['latestTimesheetId'=>$timesheet->id]);
        }
        return view('employee.home', compact('timesheet'));
    }

    public function pastTimesheet() {

        if (null == request('date')){
            return redirect('employee/home');
        }
        
        $date = date('W', strtotime(request('date')));
        if($date%2 != 1){
            $date = $date -1;
        }
        $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));

        $timesheet = Timesheet::where('userId', '=', Auth::id())->where('startdate', '=', $date)->first();

        if ($timesheet != null) {
            $shifts = Shift::where('timesheetId', '=', $timesheet->id)->get();
            return view('employee.home', compact('timesheet', 'shifts'));
        }
        return view('employee.home', compact('date', 'timesheet'));
    }

    public function createShift(){
        $diff = strtotime(request('shiftEnd')) - strtotime(request('shiftStart'));
        $hours = date('g', $diff);
        $min = date('i', $diff)/60;
        $total = $hours + $min;
        $timesheetId = request('timesheetId');

        $timesheet = Timesheet::find($timesheetId);
        $timesheet->total += $total;
        $timesheet->save();


        Shift::create([
            'date' => request('shiftDate'),
            'start' => request('shiftStart'),
            'end' => request('shiftEnd'),
            'timesheetId' => request('timesheetId'),
            'description'=> request('description'),
            'total' => $total
        ]);
        return back();
    }

    public function editShift(){
        $id = request('shiftId');
        $start = request('shiftStart');
        $end = request('shiftEnd');
        $diff = strtotime($end) - strtotime($start);
        $hours = date('g', $diff);
        $min = date('i', $diff)/60;
        $total = $hours + $min;
        $shift = Shift::find($id);
        $timesheet = Timesheet::find($shift->timesheetId);
        $timesheet->total -= $shift->total;
        $timesheet->total += $total;
        $timesheet->save();
        $shift->update(['start'=> $start, 'end' => $end, 'total'=> $total]);
        return back();
    }

    public function deleteShift(){
        $id = request('shiftId');
        $shift = Shift::find($id);
        $timesheet = Timesheet::find($shift->timesheetId);
        $timesheet->total -= $shift->total;
        $timesheet->save();
        $shift->delete();
        return back();
    }

    public function sign(){
        $timesheetId = request('timesheetId');
        return view('employee.signature', compact('timesheetId'));
    }

    public function submitTimesheet() {
        $timesheetId = request('timesheetId');
        $signature = request('signature');
        Timesheet::find($timesheetId)->update(['status'=>'submitted', 'signature'=>$signature]);
        return redirect('employee/home');
    }
}
