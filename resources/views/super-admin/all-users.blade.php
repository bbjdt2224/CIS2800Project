@extends('layouts.app')

@section('content')
    {{ csrf_field()}}
    <div class="container">
        <div class="space-between">
            <ul class="nav nav-tabs">
                <li><a href="{{route('superadminHome')}}">Organizations</a></li>
                <li class="active"><a href="#">All Users</a></li>
            </ul>
            <input type="search" id="search" placeholder="Search" class="form-control width-400" oninput="search()">
        </div>
        <ul class="list-group bottom-margin-10" id="user-list">
            @for($i = 0; $i < count($users); $i ++)
               @include('super-admin.user-list-item', [$user = $users[$i]])
            @endfor
        </ul>
    </div>
    <script>
        function search(){
            var list = document.getElementById('user-list');
            var idlist = [];
            for(var i = 0; i < list.childNodes.length; i ++) {
                if (list.childNodes[i].id && !list.childNodes[i].id.includes('edit') && !list.childNodes[i].id.includes('archive')) {
                    list.childNodes[i].classList.remove('hidden');
                    idlist.push(parseInt(list.childNodes[i].id));
                }
            }
			var val = $("#search").val();
		    $.ajax({ 
		    	headers: {
		            'X-CSRF-TOKEN': $("input[name=_token]").val()
		        }, 
		        url:"{{route('searchUsers')}}",  
		        method:"POST",  
		        data:{val:val},                              
		        success: function( data ) {
                    ids = Object.values(data).map(d => d.id);
                    remove = [];
		        	for(var i = 0; i < idlist.length; i ++) {
                        if (!ids.includes(idlist[i])) {
                            remove.push(idlist[i]);
                        }
                    }
                    for(var i = 0; i < remove.length; i++) {
                        document.getElementById(remove[i]).classList.add('hidden');
                    }
		        }
		    });
		} 
    </script>
@endsection
