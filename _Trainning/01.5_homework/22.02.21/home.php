<?
include('class/DBconnect.php');
session_start();

$sort = "time_asc";
if(isset($_POST['sort_menu'])){
	$sort = strval($_POST['sort_menu']);
	$_SESSION['sort'] = $sort;
}else{
	if(isset($_SESSION['sort'])){
		$sort = $_SESSION['sort'];
	}
}

$update = 1;
if(isset($_POST['update_time'])){
	$update = intval($_POST['update_time']);
	$_SESSION['update'] = $update;
}else{
	if(isset($_SESSION['update'])){
		$update = intval($_SESSION['update']);
	}
}

$start = '0000-00-00 00:00:00';
$end = date("Y-m-d H:i:s");
date_default_timezone_set("Asia/Taipei");
if(isset($_POST['search'])){
	$start_date = isset($_POST['start_date'])?$_POST['start_date']:'0000-00-00';
	$start_time = isset($_POST['start_time'])?$_POST['start_time']:'00:00:00';
	$end_date = isset($_POST['end_date'])?$_POST['end_date']:date('Y-m-d');
	$end_time = isset($_POST['end_time'])?$_POST['end_time']:date('H:i');
	$start = $start_date. ' '. $start_time;
	$end = $end_date. ' '. $end_time;
}

$display = read_data();
$sort_key = sort_column($sort, $display); // use $sort_key as index of $display
time_search($start, $end, $display);

if(isset($_POST['logout'])){
	unset($_SESSION['user']);
	unset($_SESSION['update']);
	unset($_SESSION['sort']);
	header("Location: home.php");
}


function read_data(){
	$filename = "/HDD/STATUSLOG/statuslog";
	$datas = array();
	exec("/bin/cat $filename", $datas);
	foreach($datas as $line){
		unset($column);
		$column = explode(',', $line);
		$display[] = array(
			'time' => $column[0],
			'load_avg1' => $column[1],
			'load_avg5' => $column[2],
			'load_avg15' => $column[3],
			'tasks' => $column[4],
			'running_tasks' => $column[5],
			'pid' => $column[6]. "<br>". $column[7]. "<br>". $column[8],
			'command' => $column[9]. "<br>". $column[10]. "<br>". $column[11],
			'cpu' => $column[12]
		);
	}
	return $display;
}

function sort_column($sort, $display){
	$option = explode("_", $sort);
	$col = $option[0];
	$dir = $option[1];
	for($i = 0; $i < count($display); $i++){
		$sort_arr[] = $display[$i][$col];
	}
	if($dir === "asc"){
		asort($sort_arr);
	}else{
		arsort($sort_arr);
	}

	$key = (array_keys($sort_arr));
	return $key;
}

function time_search($start, $end, $display){
	for($i = 0; $i < count($display); $i++){
		$a = strtotime($display[$i]['time']);
		if((strtotime($start) > $a) || ($a > strtotime($end))){
			array_splice($display, $i, 1);
		}
	}
}


include('xhtml/home.html');
?>