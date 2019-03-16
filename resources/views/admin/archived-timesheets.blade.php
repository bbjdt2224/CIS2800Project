@extends('layouts.app')

@section('content')
    <?php
        function formatDate($date) {
            return date('m/d/Y', strtotime($date));
        }
    ?>
    <div class="container">
        <ul class="nav nav-tabs">
            <li><a href="{{route('adminHome')}}">Current Timesheets</a></li>
            <li><a href="{{route('employees')}}">Employees</a></li>
            <li class="active"><a href="#">Archived Timesheets</a></li>
            <li><a href="#">Archived Employees</a></li>
        </ul>
        <div class="space-between top-margin-1">
            @if($type == 'Date')
                <h3> Filter by date:  {{formatDate($value)}} </h3> 
            @else
                <h3> Filter by name:  {{$value}} </h3> 
            @endif
            <button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter</button>
        </div>

        <div id="filter" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="get" action="{{route('archivedTimesheets')}}">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Filter</h4>
                        </div>
                        <div class="modal-body left">
                            {{ csrf_field()}}
                            <div class="form-group">
                                <select class="form-control" name="type" id="filter-type" onchange="updateFilter({{json_encode($users)}})">
                                    <option selected >Date</option>
                                    <option>Name</option>
                                </select>
                            </div>
                            <div class="form-group" id="filter-value">
                                <input class="form-control" type="date" name="value">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <ul class="list-group top-margin-1 bottom-margin-10">
            @for($i = 0; $i < count($timesheets); $i ++)
                <li class="list-group-item">
                    <a href="{{route('viewTimesheet', ['timesheetId' => $timesheets[$i]->id])}}" class="space-between">
                        <span>{{$timesheets[$i]->name}}</span>
                        <span>{{formatDate($timesheets[$i]->startDate)}}</span>
                    </a>
                </li>
            @endfor
        </ul>
    </div>
    <script>
        function updateFilter(users) {
            var type = document.getElementById('filter-type').value;
            var value = document.getElementById('filter-value');
            if (type == 'Name') {
                var select = document.createElement('select');
                select.classList.add('form-control');
                select.setAttribute('name', 'value');
                for(var i = 0; i < Object.keys(users).length; i++){
                    var option = document.createElement('option');
                    option.innerText = users[i].name;
                    select.appendChild(option);
                };
                value.replaceChild(select, value.childNodes[1]);
            }
            else if (type == 'Date') {
                var input = document.createElement('input');
                input.setAttribute('type', 'date');
                input.classList.add('form-control');
                input.setAttribute('name', 'value');
                value.replaceChild(input, value.childNodes[1]);
            }
        }
    </script>
@endsection