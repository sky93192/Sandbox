<?php

$device_list = array("eth0","eth3","eth1","eth2");
$interface = array();

foreach($device_list as $key => $dev){
	$interface[$key]['dev'] = $dev;

	$cmd1 = "/sbin/ifconfig ". $dev;
	unset($line);
	exec($cmd1, $line);
	if(!empty($line)){
		// every dev has diffrent result lines, so need to check if there is ip information in the line.
		for($i = 0; $i < count($line); $i++){
			if(strpos($line[$i], "<inet>")){
				$msg0 = preg_split("/[\s:]+/", trim($line[$i]));
				$interface[$key]['ip'] = $msg0[2];
				$interface[$key]['mask'] = $msg0[6];
				break;
			}
		}

		$cmd2 = "/sbin/ip -s link show ". $dev;
		unset($txrx_check);
		exec($cmd2, $txrx_check);
		$rx_msg = preg_split("/[\s]+/", trim($txrx_check[3]));
		$tx_msg = preg_split("/[\s]+/", trim($txrx_check[5]));
		$interface[$key]['flow'] = $tx_msg[0]. " / ". $rx_msg[0];
		$interface[$key]['packets'] = $tx_msg[1]. " / ". $rx_msg[1];
		$interface[$key]['errors'] = $tx_msg[2]. " / ". $rx_msg[2];

		$cmd3 = "/bin/cat /sys/class/net/". $dev. "/carrier";
		unset($link_check);
		exec($cmd3, $link_check);
		if(empty($link_check)){
			$interface[$key]['link'] = "No";
		}else{
			$interface[$key]['link'] = "Yes";
		}

		$cmd4 = "/bin/cat /ram/tmp/wanstatus";
		unset($conn_check);
		exec($cmd4, $list);
		if($dev === "eth0" || $dev === "eth3"){
			if($interface[$key]['link'] === "Yes"){
				$interface[$key]['connect'] = "Yes";
			}else{
				$interface[$key]['connect'] = "No";
			}
		}elseif($dev === "eth1"){
			$conn_check = explode("=", $list[0]);
			if($conn_check[1] === "OFF"){
				$interface[$key]['connect'] = "No";
			}else{
				$interface[$key]['connect'] = "Yes";
			}
		}elseif($dev === "eth2"){
			foreach($list as $row){
				if(strpos($row, "WAN2") !== false){
					$devline = $row;
				}
			}
			if(isset($devline)){
				$conn_check = explode("=", $devline);
				if($conn_check[1] === "OFF"){
					$interface[$key]['connect'] = "No";
				}else{
					$interface[$key]['connect'] = "Yes";
				}
			}
		}

	}

}

include('./xhtml/showinterface.html');