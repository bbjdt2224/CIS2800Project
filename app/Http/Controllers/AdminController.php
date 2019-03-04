<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Timesheet;
use App\User;
use App\Shift;
use App\Header;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function adminHome() {

        $date = date('W', time());
        if($date%2 != 1){
            $date = $date -1;
        }
        $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));

        $users = User::leftJoin('timesheets', 'users.latestTimesheetId', '=', 'timesheets.id')
        ->where('users.organizationId', '=', Auth::user()->organizationId)
        ->orderby('users.name')
        ->groupBy('timesheets.userId')
        ->get();
        
        return view('admin.home', compact('users'));
    }

    public function viewTimesheet($id) {

        $date = date('W', time());
        if($date%2 != 1){
            $date = $date -1;
        }
        $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));

        $timesheet = Timesheet::find($id);

        $user = User::find($timesheet->userId);

        $headers = Header::where('userId', '=', $timesheet->userId)->get();

        $shifts = Shift::where('timesheetId', '=', $timesheet->id)->get();

        $userList = User::leftJoin('timesheets', 'users.latestTimesheetId', '=', 'timesheets.id')
        ->where('users.organizationId', '=', Auth::user()->organizationId)
        ->where('timesheets.startdate', '=', $date)
        ->orderby('users.name')
        ->get();

        return view('admin.timesheet', compact('user', 'headers', 'timesheet', 'shifts', 'userList'));
    }

    public function approveTimesheet() {
        $id = request('timesheetId');
        Timesheet::find($id)->update(['status'=>'approved']);
        return back();
    }

    public function rejectTimesheet() {
        $id = request('timesheetId');
        $notes = request('notes');
        Timesheet::find($id)->update([
            'status'=>'rejected',
            'notes'=>$notes
        ]);
        return back();
    }
}
