<div id="{{$shift->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('editShift')}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Shift</h4>
                </div>
                <div class="modal-body left">
                    {{ csrf_field()}}
                    <input type="hidden" name="shiftId" value="{{$shift->id}}">
                    <input type="hidden" name="date" value="{{$shift->date}}">
                    <div class="form-group">
                        <label class="form-label">Start Time: </label>
                        <input class="form-control" type="time" name="shiftStart" value="{{$shift->start}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Time: </label>
                        <input class="form-control" type="time" name="shiftEnd" value="{{$shift->end}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description: </label>
                        <textarea class="form-control" name="description">{{$shift->description}}</textarea>
                    </div>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#delete{{$shift->id}}">Delete</button>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="delete{{$shift->id}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('deleteShift')}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete Shift</h4>
                </div>
                <div class="modal-body left">
                    {{ csrf_field()}}
                    <input type="hidden" name="shiftId" value="{{$shift->id}}">
                    <h3 class="center"> Are you sure you want to delete this shift?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>