<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shifts;

class ShiftController extends Controller
{
    public function add($start, $end, $timesheet, $description, $total){
    	Shifts::create([
    		'start' => $start,
    		'end' => $end,
    		'timesheetId' => $timesheet,
            'description' => $description,
            'total' => $total,
    	]);
    	return;
    }

    public function edit($start, $end, $timesheet, $id, $description, $total){
    	Shifts::find($id)->update(['start'=> $start, 'end' => $end, 'timesheet'=> $timesheet, 'description' => $description, 'total' => $total]);
        return;
    }

}