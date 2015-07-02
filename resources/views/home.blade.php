@extends('layouts.dashboard')
@section('page_heading','Servers')
@section('section')
<div class="col-sm-12">
<div class="row">
    <div class="col-sm-12">
        @if($servers)
        <form class="form-inline col-sm-12" method="get" id="stat-page-list-form">
          <div class="form-group">
            <label for="exampleInputName2">Server List&nbsp;&nbsp;</label>
            <select class="form-control" id="select_server_list">
            @foreach($servers as $key => $server)
              @if($server_id)
                @if($server_id == $key)
                    <option value="{{$key}}" selected="selected">{{$server}}</option>
                @else
                    <option value="{{$key}}">{{$server}}</option>
                @endif    
              @else
                <option value="{{$key}}">{{$server}}</option>
              @endif  
            @endforeach  
            </select>
          </div>
          <div class="form-group">
          <button type="button" class="btn btn-default" id="button-stat-form-submit">Get statistics</button>
          </div>
        </form>
        @else
        <div class="alert alert-warning " role="alert">
            <i class="fa fa-warning"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  There is no servers in database. <a href="{{URL::to('pull-servers')}}">Click here</a> to pull server list.
        </div>
        @endif
    </div>
</div>
<hr/>
<div class="row" id="server_statistics_row">
@if(!empty($server_statistics))
    <div class="panel panel-default">
      <div class="panel-heading">
          <h3 class="panel-title">Line chart</h3>
      </div>
      <div class="panel-body" id="stocks-div">
      </div>
    </div>
    @linechart('server-stat', 'stocks-div', true)
    <ul class="list-inline">
      <li>
          Lowest Value : <span class="btn btn-danger">{{$server_statistics_low->data_value}}</span>          
      </li>
      <li>
          Average Value : <span class="btn btn-info">{{$server_statistics_avg}}</span>          
      </li>
      <li>
          Highest Value : <span class="btn btn-success">{{$server_statistics_high->data_value}}</span>          
      </li>
    </ul>
@else
    @if($server_id)
        <div class="alert alert-warning " role="alert">
           <i class="fa fa-warning"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  System didnot find any statistics data for this server.<a class="btn-link btn"  id="pull-stat-remote" data-value="{{$server_id}}">Click here</a>to pull statistics from remote server.
    </div>
    @endif
@endif
</div>
</div>
@stop
