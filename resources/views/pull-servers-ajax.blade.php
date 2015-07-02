 @if($servers)
 <div class="col-sm-12">
			@section ('cotable_panel_title','Server list')
			@section ('cotable_panel_body')
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>URL</th>
						<th>Action</th>
					</tr>
				</thead>
				
				<tbody>
				@foreach($servers as $key => $server)
					<tr class="success" >
						<tr class="success" >
						<td style="width:5% !important;">{{$key}}</td>
						<td>{{$server}}</td>
						<td style="width:15% !important;"><a href="{{URL::to('view-stat/' .$key)}}">View statistics</a></td>
					</tr>
					</tr>
				@endforeach	
				</tbody>
			</table>	
			@endsection
			@include('widgets.panel', array('header'=>true, 'as'=>'cotable'))
		</div>
	</div>
@else
    <div class="alert alert-warning " role="alert">
        <i class="fa fa-warning"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  There is no servers in database.
    </div>
@endif	