<?
// executed by cron every minute.

$filename = "/HDD/STATUSLOG/statuslog";
if(!is_file($filename)){
	exec("/bin/mkdir /HDD/STATUSLOG; /bin/touch $filename");
}

unset($result1);
exec("/usr/bin/uptime", $result1);
$msg1 = preg_split("/[\s,]+/", trim($result1[0]));
$data_time = date("Y-m-d"). ' '.$msg1[0];

unset($result2);
exec("/bin/cat /proc/loadavg", $result2);
$msg2 = preg_split("/[\s]+/", trim($result2[0]));
$data_loadavg1 = $msg2[0];
$data_loadavg5 = $msg2[1];
$data_loadavg15 = $msg2[2];

unset($result3);
exec("/usr/bin/top -b -n 1 | grep Tasks", $result3);
$msg3 = preg_split("/[\s:,]+/", trim($result3[0]));
$data_tasks = $msg3[1];
$running_tasks = $msg3[3];

unset($result4);
exec("/bin/ps aux --sort=%cpu | head -4", $result4);
array_splice($result4, 0, 1);
foreach($result4 as $line){
	$msg4 = preg_split("/[\s]+/", trim($line));
	$data_pid[] = $msg4[1];
	$pid_command[] = $msg4[10];
}

unset($result5);
exec("/bin/cat /proc/stat | grep cpu", $result5);
$result5 = array_splice($result5, 0, 1);
$msg5 = preg_split("/[\s]+/", trim($result5[0]));
$new_cpu_idle = intval($msg5[4]);
$new_cpu_total = intval($msg5[1]) + intval($msg5[2]) + intval($msg5[3]) + intval($msg5[4]) + intval($msg5[5]) + 
intval($msg5[6]) + intval($msg5[7]) + intval($msg5[8]) + intval($msg5[9]) + intval($msg5[10]);
$cpu_usage = cpu_data($filename, $new_cpu_idle, $new_cpu_total);

$dataline = $data_time. ','. $data_loadavg1. ','. $data_loadavg5. ','. $data_loadavg15. ','. $data_tasks. ','. $running_tasks. ','. 
implode(',', $data_pid). ','. implode(',', $pid_command). ','. $cpu_usage. "\n";

$count = 0;
$fp = fopen($filename, 'r+');
while(fgets($fp) !== false){
	$count++;
}
if($count < 3500){
	fwrite($fp, $dataline);
}else{
	ftruncate($fp, 0);
	fwrite($fp, $dataline);
}
fclose($fp);


function cpu_data($filename, $new_cpu_idle, $new_cpu_total){
	$count = 0;
	$fp = fopen($filename, 'r');
	while(fgets($fp) !== false){
		$count++;
	}

	if($count >= 2){
		unset($data);
		exec("/bin/tail -n 2 $filename", $data);
		$old_col = explode(',', $data[0]);
		$cpu_old = array(
			'idle' => intval($old_col[10]),
			'total' => intval($old_col[11])
		);
		
		$cpu_new = array(
			'idle' => intval($new_cpu_idle),
			'total' => intval($new_cpu_total)
		);
		
		$result = number_format((1 - ($cpu_new['idle'] - $cpu_old['idle']) / ($cpu_new['total'] - $cpu_old['total'])), 3);

	}else{
		$cpu_old = array(
			'idle' => intval($new_cpu_idle),
			'total' => intval($new_cpu_total)
		);
		
		$result = number_format((1 - ($cpu_old['idle'] / $cpu_old['total'])), 3);
	}
	
	fclose($fp);
	$usage = "$result". '%';
	return $usage;

}

?>