<?php namespace App\Http\Controllers;
use DB;
use Input;
use Request;
class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	public function viewServerStat($id){
		$servers = DB::table('servers')->lists('server', 'id');
		$server = DB::table('servers')->select('server', 'id')->where('id', $id)->first();
		$server_statistics = DB::table('server_statistics')->where('server_id', $id)->get();
		
		$linechart = \Lava::DataTable();

    	$linechart->addDateColumn('Date')->addNumberColumn('Sample Value');

    	foreach ($server_statistics as $key => $value) {
    		# code...
    		$rowData = array(
	          $value->data_label, $value->data_value
	        );

	        $linechart->addRow($rowData);
    	}

	    $lineChart = \Lava::LineChart('server-stat')
                    ->setOptions(array(
                        'datatable' => $linechart,
                        'title' => 'Server statistics for ' . ucfirst($server->server)
                      ));

    	//dd($rowData);
		$server_statistics_low = DB::table('server_statistics')->select('data_value')->where('server_id', $id)->orderBy('data_value', 'asc')->first();
		$server_statistics_high = DB::table('server_statistics')->select('data_value')->where('server_id', $id)->orderBy('data_value', 'desc')->first();
		$server_statistics_avg = DB::table('server_statistics')->select('data_value')->where('server_id', $id)->avg('data_value');
		if(!Request::ajax()){
			return view('home', array('server_statistics_low' => $server_statistics_low, 'server_statistics_high' => $server_statistics_high, 'server_statistics_avg' => $server_statistics_avg, 'server_statistics' => $server_statistics, 'servers' => $servers, 'server_id' => $id));
		}else{
			return view('pull-servers-stat-ajax', array('server_statistics_low' => $server_statistics_low, 'server_statistics_high' => $server_statistics_high, 'server_statistics_avg' => $server_statistics_avg, 'server_statistics' => $server_statistics, 'servers' => $servers, 'server_id' => $id));
		}	
	}

	public function fetchServers(){
		$source_url  	= 'http://www.sublimegroup.net/st4ts/data/get/type/servers/';
		// make request using curl.
		// used curl because other methods were not getting data
		$ch 			= curl_init();
		curl_setopt($ch, CURLOPT_URL, $source_url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output 		= curl_exec($ch);
		curl_close($ch);
		// decode the json
		$server_list 	= json_decode($output, true);
		$servers = array();
		if(!empty($server_list)){
			foreach($server_list as $server){
				$server_link = trim($server['s_system']);
				$servers[] 	= array('server' => $server_link);
			}
		}
		// clear db
		DB::table('servers')->truncate();
		DB::table('server_statistics')->truncate();
		// insert server list
		DB::table('servers')->insert($servers);
		return $servers;
	}

	/*
		Method to fetch statistics
	*/
	public function fetchServerStat(){
		$server_id = Input::get('server_id');
		/* Get list and take stat */
		$server = DB::table('servers')->where('id', $server_id)->pluck('server');;
		$server_stat_in = array();
		if(!empty($server)){
			$server_link = trim($server);
			$source_stat_url 	= 'http://www.sublimegroup.net/st4ts/data/get/type/iq/server/' . $server_link;
			// fetch URL data
			$output_stat 		= file_get_contents($source_stat_url);
			$server_stat_list 	= json_decode($output_stat);
			foreach($server_stat_list as $key => $list_stat){
				$server_stat_in[]	= array("server_id" => $server_id, "data_value" => $list_stat->data_value, "data_label" => $list_stat->data_label);
			}
		}
		// clear db
		DB::table('server_statistics')->where('id', $server_id)->delete();
		// insert
		DB::table('server_statistics')->insert($server_stat_in);	
	}

}
