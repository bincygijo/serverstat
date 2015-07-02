@extends('layouts.dashboard')
@section('page_heading','Servers')
@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-lg-6">
        <h2>Select server</h2>
        <form class="form-inline">
		  <div class="form-group">
		    <label for="exampleInputName2">Server List&nbsp;&nbsp;</label>
		    <select class="form-control">
			  <option>asdasdad1</option>
			  <option>2asdasdasd</option>
			  <option>3asdasd</option>
			  <option>4asdasd</option>
			  <option>5asdasdasd</option>
			</select>
		  </div>
		  <button type="submit" class="btn btn-default">Get statistics</button>
		</form>
    </div>
</div>
</div>
@stop
