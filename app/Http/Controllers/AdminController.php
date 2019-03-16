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

    public function employees() {
        $employees = User::where('organizationId', '=', Auth::user()->organizationId)
        ->orderby('name')
        ->get();

        return view('admin.employees', compact('employees'));
    }

    public function editEmployee($employeeId) {
        $employeeId = intval($employeeId);
        $employee = User::find($employeeId);

        return view('admin.edit-employee', compact('employee'));
    }

    public function edit() {
        $id = request('employeeId');
        User::find($id)->update([
            'name' => request('name'),
            'email' => request('email')
        ]);
        return redirect('admin/employees');
    }

    public function archiveEmployee() {
        $id = request('employeeId');
        User::find($id)->delete();
        return redirect('admin/employees');
    }

    public function unarchiveEmployee() {
        $id = request('employeeId');
        User::withTrashed()->find($id)->restore();
        return redirect('admin/archivedEmployees');
    }

    public function viewArchivedTimesheets() {
        $type = request('type');
        $value = request('value');

        $date = date('W', time());

        if ($type == null) { 
            $type = 'Date'; 
        }
        if ($type == 'Date') {
            if ($value !== null) {
                $date = date('W', strtotime($value));
            }
            if($date%2 != 1){
                $date = $date -1;
            }
            $value = date('Y-m-d', strtotime(date('Y')."W".sprintf("%02d", $date)."1"));
        }

        $timesheets = null;

        switch ($type) {
            case 'Date':
                $timesheets = Timesheet::where('organizationId', '=', Auth::user()->organizationId)
                ->where('startDate', 'like', $value)
                ->join('users', 'timesheets.userId', '=', 'users.id')
                ->orderby('name', 'ASC')
                ->get();
                break;
            case 'Name':
                $timesheets = Timesheet::where('organizationId', '=', Auth::user()->organizationId)
                ->where('name', '=', $value)
                ->join('users', 'timesheets.userId', '=', 'users.id')
                ->orderby('startDate', 'DESC')
                ->get();
                break;
        }
        
        $users = User::where('organizationId', '=', Auth::user()->organizationId)->get();

        return view('admin.archived-timesheets', compact('type', 'value', 'timesheets', 'users'));
    }

    function viewArchivedEmployees() {
        $users = User::onlyTrashed()->where('organizationId', '=', Auth::user()->organizationId)->get();
        return view('admin.archived-employees', compact('users'));
    }
}
