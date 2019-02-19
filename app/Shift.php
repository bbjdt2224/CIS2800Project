<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class shift extends Controller
{
    protected $fillable = [
        'start', 'end', 'timesheetId', 'description', 'total',
    ];
}
