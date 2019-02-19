@extends('layouts.app')

@section('page')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Welcome, {{$name}}</a>
            </div>
            <form class="navbar-form navbar-left" action="/action_page.php">
                <div class="form-group">
                    <input type="date" class="form-control" value="{{date('Y-m-d')}}">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('welcome') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </div>
    </nav>
    <table class="table">
        <thead>
            <th></th>
            <th>Sunday</th>
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wednesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
        </thead>
    </table>
@endsection