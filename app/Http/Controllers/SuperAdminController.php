<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Timesheet;
use App\User;
use App\Shift;
use App\Header;
use App\Organization;

class SuperAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('superadmin');
    }

    public function home() {
        $admins = User::where('role', '=', 'admin')
        ->select('users.id', 'organizationId', 'name', 'email', 'title', 'members')
        ->orderby('name', 'ASC')
        ->join('organizations', 'organizations.id', '=', 'users.organizationId')
        ->get();

        return view('super-admin.home', compact('admins'));
    }

    public function createOrganization() {
        $org = Organization::create([
            'title'=>request('orgName')
        ]);

        User::create([
            'name'=>request('name'),
            'email'=>request('email'),
            'password'=>'$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'organizationId'=>$org->id,
            'role'=>'admin',
            'password_token'=>\str_random(100)
        ]);
        return back();
    }

    public function editOrganization() {
        $userId = request('userId');
        $orgId = request('orgId');

        User::find($userId)->update([
            'name'=>request('name'),
            'email'=>request('email')
        ]);

        Organization::find($orgId)->update([
            'title'=>request('orgName')
        ]);
        return back();
    }

    public function archiveOrganization() {
        $id = request('employeeId');
        $admin = User::find($id);
        $employees = User::where('organizationId', '=', $admin->organizationId);
        for($i = 0; $i < sizeof($employees); $i++) {
            User::find($employees[$i])->delete();
        }
        $admin->delete();
        return back();
    }

    public function allUsers() {
        $users = User::where('role', '<>', 'superadmin')
        ->select('users.id', 'name', 'email', 'role', 'title')
        ->orderby('name', 'ASC')
        ->join('organizations', 'organizations.id', '=', 'users.organizationId')
        ->get();

        return view('super-admin.all-users', compact('users'));
    }

    public function editUser() {
        $id = request('userId');
        User::find($id)->update([
            'name' => request('name'),
            'email' => request('email')
        ]);

        return back();
    }
}
