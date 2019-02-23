@extends('layouts.app')
{{-- signature box for signing a submitted timesheet --}}
@section('content')
	<div class="container">
		<form action="{{route('submitTimesheet')}}" method="post">
            {{ csrf_field()}}
			<fieldset>
		          <legend><h4>Signature</h4></legend>
		          <div class="signature-wrapper"><canvas id="signature" class="signature-pad" width="600px" height="150px"></canvas></div>
				  <input type="hidden" name="signature" id="signature-input">
		          <input type="hidden" name="timesheetId" value="{{$timesheetId}}">
		          <button id="submit" class="button tiny alert">Submit</button>
		          <button id="clear-signature" class="button tiny alert">Clear</button>
		          
			</fieldset>
		</form>
		{{-- scripts for allowing drawing and saving of signature --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
		<script src={{asset('js/signature.js')}}></script>
		<script>signature();</script>
	</div>
@endsection