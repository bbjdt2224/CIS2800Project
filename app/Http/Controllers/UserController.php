<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Timesheet;
use App\Shift;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
                'submitted' => 0,
                'total' => 0
            ]);
        }
        return view('employee.home', compact('date', 'timesheet'));
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
        Shift::find($id)->update(['start'=> $start, 'end' => $end]);
        return back();
    }

    public function adminHome() {
        
        return view('admin.home');
    }
}
