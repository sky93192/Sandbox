<?php

// delete
if(isset($_POST['delete'])){
	$ip = $_POST['selected_dev'];
	exec("/sbin/arp -d $ip", $a, $del_check);
	if($del_check === 0){
		echo "<script type='text/javascript'>alert('Delete successful!');window.location.href='showarp.php';</script>";
		exit;
	}else{
		echo "<script type='text/javascript'>alert('Delete failed');window.location.href='showarp.php';</script>";
		exit;
	}
	
}

// add
// input check
if(isset($_POST['add_ip'])){
	$ip = $_POST['ip'];
	$mac = $_POST['mac'];
	$dev = $_POST['dev'];

	if(empty($ip) || empty($mac)){
		echo "<script type='text/javascript'>alert('Please enter value');history.go(-1);</script>";
		exit;
	}elseif(!preg_match("/^([0-9]{1,3}\.){3}[0-9]{1,3}$/", $ip)){
		echo "<script type='text/javascript'>alert('Please enter valid IP address');history.go(-1);</script>";
		exit;
	}elseif(!preg_match("/^([0-9A-Fa-f]{2}[:]){5}([0-9A-Fa-f]{2})$/", $mac)){
		echo "<script type='text/javascript'>alert('Please enter valid MAC address with \":\"');history.go(-1);</script>";
		exit;
	}elseif(!empty($dev)){
		if(!($dev == "eth0" || $dev == "eth3")){
			echo "<script type='text/javascript'>alert('Only allowed to add new IP on device eth0 or eth3');history.go(-1);</script>";
			exit;
		}

	}

	// adding
	if(!empty($dev)){
		$ip_long = ip2long("$ip");
		exec("/sbin/ifconfig $dev", $info);
		foreach($info as $key => $line){
			if(strpos($line, "Mask")){
				$msg = preg_split("/[\s:]+/", trim($line));
				$current_ip_long = ip2long("$msg[2]");
				$mask_long = ip2long("$msg[6]");
				$first_ip_long = $current_ip_long & $mask_long;
				$bcast = ip2long("$msg[4]");
		
				if($ip_long > $first_ip_long && $ip_long < $bcast){
					exec("/sbin/arp -i $dev -s $ip $mac", $add_check);
					if($add_check == 0){
						echo "<script type='text/javascript'>alert('Add successful!');window.location.href='showarp.php';</script>";
						exit;
					}else{
						echo "<script type='text/javascript'>alert('Add failed');history.go(-1);</script>";
						exit;
					}
				}else{
					echo "<script type='text/javascript'>alert('Add failed');history.go(-1);</script>";
					exit;
				}
			}
		}
		
		echo "<script type='text/javascript'>alert('The device if off');history.go(-1);</script>";
		exit;
		
	}else{
		exec("/sbin/arp -s $ip $mac", $a, $add_check);
		unset($a);
		if($add_check == 0){
			echo "<script type='text/javascript'>alert('Add successful!');window.location.href='showarp.php';</script>";
			exit;
		}else{
			echo "<script type='text/javascript'>alert('Add failed');window.location.href='showarp.php';</script>";
			exit;
		}
	}

}

// display arp information
exec("/sbin/arp | grep ether", $arp_arr);
foreach($arp_arr as $key => $line){
	$line = preg_split("/[\s]+/", $line);
	$arp[$key]['ip'] = $line[0];
	$arp[$key]['mac'] = $line[2];
	$arp[$key]['interface'] = $line[4];
}

include('./xhtml/showarp.html');