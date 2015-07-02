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