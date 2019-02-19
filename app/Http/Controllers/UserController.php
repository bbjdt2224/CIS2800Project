<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function employeeHome() {
        
        $name = 'Justin';

        return view('employee.home', compact('name'));
    }

    public function adminHome() {
        
        return view('admin.home');
    }
}
