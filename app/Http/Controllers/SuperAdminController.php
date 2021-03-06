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

    // get all admins and thier organization
    public function home() {
        $admins = User::where('role', '=', 'admin')
        ->select('users.id', 'organizationId', 'name', 'email', 'title', 'members')
        ->orderby('name', 'ASC')
        ->join('organizations', 'organizations.id', '=', 'users.organizationId')
        ->get();

        return view('super-admin.home', compact('admins'));
    }

    // make a new organization and admin
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

    // edit organization or admin information
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

    // archive organization
    public function archiveOrganization() {
        $id = request('employeeId');
        $admin = User::find($id);
        $employees = User::where('organizationId', '=', $admin->organizationId)->get();
        for($i = 0; $i < sizeof($employees); $i++) {
            User::find($employees[$i]->id)->delete();
        }
        return back();
    }

    // get all users in database
    public function allUsers() {
        $users = User::where('role', '<>', 'superadmin')
        ->select('users.id', 'name', 'email', 'role', 'title')
        ->orderby('name', 'ASC')
        ->join('organizations', 'organizations.id', '=', 'users.organizationId')
        ->get();

        return view('super-admin.all-users', compact('users'));
    }

    // search for a user by name
    public function searchUsers() {
        $val = request('val');
        $users = User::where('role', '<>', 'superadmin')
        ->where('name', 'like', '%'.$val.'%')
        ->select('users.id')
        ->orderby('name', 'ASC')
        ->join('organizations', 'organizations.id', '=', 'users.organizationId')
        ->get();
        return $users;
    }

    // edit a users information
    public function editUser() {
        $id = request('userId');
        User::find($id)->update([
            'name' => request('name'),
            'email' => request('email')
        ]);

        return back();
    }

    // archive a user
    public function archiveEmployee() {
        $id = request('employeeId');
        User::find($id)->delete();
        return back();
    }
}
