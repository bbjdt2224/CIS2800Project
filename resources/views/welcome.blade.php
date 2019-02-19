@extends('layouts.app')

@section('page')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">WMU Scheduling</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('employeeHome') }}"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li><a href="{{ route('login') }}"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
            </ul>
        </div>
    </nav>
    <div class="flex-center position-ref full-height">

        <div class="jumbotron">
            <h1>Welcome</h1>
        </div>
    </div>
@endsection
