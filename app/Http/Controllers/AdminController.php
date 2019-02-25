<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        
        return view('admin.home');
    }

    public function viewTimesheet($id) {

        $date = date('W', time());
        if($date%2 != 1){
            $date = $date -1;
        }
        $date = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));

        $user = User::find($id);

        $headers = Header::where('userId', '=', $id)->get();

        $timesheet = Timesheet::where('userId', '=', $id)->where('startdate', '=', $date)->first();

        $shifts = Shift::where('timesheetId', '=', $timesheet->id)->get();

        return view('admin.timesheet', compact('user', 'headers', 'timesheet', 'shifts'));
    }
}
