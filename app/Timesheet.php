<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class timesheet extends Controller
{
    protected $fillable = [
        'userId', 'startDate', 'submitted', 'total',
    ];
}
