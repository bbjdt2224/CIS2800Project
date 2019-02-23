<?php
    $date = date('Y-m-d', strtotime($date));
?>
<div id="{{$dateId}}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{route('newShift')}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">New Shift</h4>
                </div>
                <div class="modal-body left">
                    {{ csrf_field()}}
                    <input type="hidden" name="timesheetId" value="{{$timesheet->id}}">
                    <input type="date" style="display:none" name="shiftDate" value="{{$date}}">
                    <div class="form-group">
                        <label class="form-label">Start Time: </label>
                        <input class="form-control" type="time" name="shiftStart">
                    </div>
                    <div class="form-group">
                        <label class="form-label">End Time: </label>
                        <input class="form-control" type="time" name="shiftEnd">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Description: </label>
                        <textarea class="form-control" name="description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>