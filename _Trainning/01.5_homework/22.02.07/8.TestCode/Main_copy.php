#!/PGRAM/php/bin/php -q
<?
	// Main.php is executed by cron once a minute, eg: 09:00:00, 09:01:00, 09:02:00 
	include_once("PortDev.php");
	$port = new Port();
	$aPortDev = $port->get_port_dev();
	ksort($aPortDev);
	$filename = "/PCONF/IFdata";

	$refresh = 2;
	$aIFTxRx = array(); // 儲存連線狀態資料
	read_ifdata(&$refresh, &$aIFTxRx);
	// 每分鐘執行一次 兩分鐘刷新一次

	if(is_file("/ram/tmp/wanstatus")) {
		$wanstatus = file("/ram/tmp/wanstatus");
		// WAN1=eth1=192.168.189.108
		// WAN2=OFF=OFF
		// WAN3=OFF=OFF
	} else {
		$wanstatus = array(
			0 => "WAN1=OFF=OFF",
			1 => "WAN2=OFF=OFF",
			2 => "WAN3=OFF=OFF",
			3 => "WAN4=OFF=OFF",
			4 => "WAN5=OFF=OFF"
		);
	}
	$eth0_RxTx = fetchRxTx("eth0_arr", "eth0");
	$a = explode("=", $wanstatus[0]);
	// $a = array(WAN1,eth1,192.168.189.108)
	$eth1_RxTx = fetchRxTx("eth1_arr", $a[1]);
	// 印出網卡資訊
	echo "$eth0_RxTx\n";
	echo "$eth1_RxTx\n";
	// 處理從class的設定檔來的裝置
	// $aPortDev[3] = L2
	foreach($aPortDev as $dev){
		switch($dev){
			case "L2":
				$eth3_RxTx = fetchRxTx("eth3_arr", "eth3");
				echo "$eth3_RxTx\n";
				break;
			case "W2":
				$b = explode("=", $wanstatus[1]);
				$eth2_RxTx = fetchRxTx("eth2_arr", $b[1]);
				echo "$eth2_RxTx\n";
				break;
			case "W3":
				$c = explode("=", $wanstatus[2]);
				$eth4_RxTx = fetchRxTx("eth4_arr", $c[1]);
				echo "$eth4_RxTx\n";
				break;
			case "W4":
				$d = explode("=", $wanstatus[3]);
				$eth5_RxTx = fetchRxTx("eth5_arr", $d[1]);	
				echo "$eth5_RxTx\n";
				break;
			case "W5":
				$e = explode("=", $wanstatus[4]);
				$eth6_RxTx = fetchRxTx("eth6_arr", $e[1]);	
				echo "$eth6_RxTx\n";
				break;
			case "L1A":
				$eth01_RxTx = fetchRxTx("eth01_arr", "eth01");
				echo "$eth01_RxTx\n"; // Device "eth01" does not exist.
				break;
			case "L1B":
				$eth02_RxTx = fetchRxTx("eth02_arr", "eth02");
				echo "$eth02_RxTx\n";
				break;
			case "L1C":
				$eth03_RxTx = fetchRxTx("eth03_arr", "eth03");
				echo "$eth03_RxTx\n";
				break;
		}
	}

	echo "--------get_ethinfo--------\n";
	get_ethinfo();
	echo "--------get_dns--------\n";
	get_dns();
	echo "--------cpuloading--------\n";
	cpuloading();
	echo "--------hddinfo--------\n";
	hddinfo();
	echo "--------meminfo--------\n";
	meminfo();

	// 回傳查完整理好的資訊，顯示並儲存
	function fetchRxTx($devS, $devR) { // eth01_arr, eth01 沒有的
		global $refresh, $aIFTxRx;

		$timestamp = time(); // Unix時間
		$Min = date("i", $timestamp); // 轉換成分鐘
		if(intval($Min) % $refresh != 0) {
			return "";
		}
		// 分鐘不整除刷新時間的話 回傳空字串

		if($aIFTxRx[$devS]) { //$aIFTxRx[eth0_arr], $aIFTxRx[eth1_arr]
			$rxflow_old = $aIFTxRx[$devS][0]; // $aIFTxRx[eth0_arr][0] = 24699850
			$txflow_old = $aIFTxRx[$devS][1]; // $aIFTxRx[eth0_arr][1] = 2032
			$rxpack_old = $aIFTxRx[$devS][2]; // $aIFTxRx[eth0_arr][2] = 301983
			$txpack_old = $aIFTxRx[$devS][3]; // $aIFTxRx[eth0_arr][3] = 42
		}

		exec("/sbin/ip -s link show $devR", $ret);
		// 查閱裝置資訊，如果沒有會變成Device "eth01" does not exist.的訊息

		$arx = listStringSplit(trim($ret[3]));
		$rxflow = trim($arx[0]); // RX bytes 12833020
		$rxpack = trim($arx[1]); // packets 158020

		$atx = listStringSplit(trim($ret[5]));
		$txflow = trim($atx[0]); // TX bytes 1066
		$txpack = trim($atx[1]); // packets 19
		// 計算單一分鐘的傳輸量：（此次總量-上次總量）/刷新時間
		$rxflowdiff = ($rxflow_old) ? (floor(($rxflow - $rxflow_old) / $refresh)) : $rxflow; // 12833020
		$txflowdiff = ($txflow_old) ? (floor(($txflow - $txflow_old) / $refresh)) : $txflow; // 1066
		$rxpackdiff = ($rxpack_old) ? (floor(($rxpack - $rxpack_old) / $refresh)) : $rxpack; // 158020
		$txpackdiff = ($txpack_old) ? (floor(($txpack - $txpack_old) / $refresh)) : $txpack; // 19

		$aNewData = array($rxflow,$txflow,$rxpack,$txpack); // 12833020,1066,158020,19
		// 儲存資料
		write_ifdata($devS, $aNewData);

		$rxflowdiff = $rxflowdiff * 8; // 102664160
		$txflowdiff = $txflowdiff * 8; // 8528

		return "$rxflowdiff,$txflowdiff,$rxpackdiff,$txpackdiff,$rxflow,$txflow,$rxpack,$txpack";
		// 102664160,8528,158020,19,12833020,1066,158020,19
	}

	// 設定刷新時間和$aIFTxRx的資訊
	function read_ifdata(&$refresh, &$aIFTxRx) {
		global $filename;

		// 不存在的話做這個
		if(!is_file($filename))	{
			$val = "refresh = " . $refresh;
			exec("/bin/echo \"".$val."\" >> " . $filename);
			return;
		}
		// 建立這個檔案 內容為refresh = 2

		$aData = file($filename);
		foreach($aData as $line){
			$aTmp = explode("=", $line);
			if(strstr($line, "refresh")) {
				// 已經有檔案的話 更新refresh
				$refresh = trim($aTmp[1]);
			} else {
				$key = trim($aTmp[0]); // $key = eth0_arr
				$aTmp[1] = trim($aTmp[1]); //$aTmp = 24699850,2032,301983,42
				$aIFTxRx[$key] = explode(",", $aTmp[1]); // $aIFTxRx[eth0_arr] = array(24699850,2032,301983,42)
				print_r($aIFTxRx);
			}
		}
	}

	// 從檔案裡找出裝置和其詳細內容 覆寫至$filename
	function write_ifdata($dev, $aNewData) { // eth0_arr, 12833020,1066,158020,19
		global $filename;
		$aData = file($filename);
		$found = false;
		// 整理內容並寫入
		foreach($aData as $key => $line) {
			$aTmp = explode("=", $line);
			if($dev == trim($aTmp[0])) {
				$aData[$key] = $dev . " = ".implode(",", $aNewData) . "\n";
				$found = true;
				break;
			}
		}
		// refresh = 2
		// eth0_arr = 12004295,1066,148193,19
		// eth1_arr = 13638329,1660706,164654,16267
		// eth2_arr = ,,,
		// eth4_arr = ,,,
		// eth5_arr = 552603,552603,10215,10215
		// eth3_arr = 0,0,0,0

		// 寫入新資料
		if(!$found)	{
			$aData[$key + 1] = $dev . " = ".implode(",", $aNewData) . "\n";
		}

		// 寫入暫存檔
		$tmp_filename = $filename . "_tmp";
		$fp = fopen($tmp_filename, "w+");
		foreach ($aData as $value) {
			fwrite($fp, $value);
		}
		fclose($fp);

		// 改回原檔名
		if(is_file($tmp_filename)) {
			exec("/bin/mv ".$tmp_filename." ".$filename);
		} else {
			@unlink($tmp_filename);
			@unlink($filename);
		}
	}

	// 抓出所有網卡的資料
	function get_ethinfo(){
		$dev = array("eth0" , "eth1" , "eth2" , "eth3");
		$msg0 = array();
		if(file_exists("/ram/tmp/wanstatus")){
			exec("cat /ram/tmp/wanstatus", $msg0);
		}
		for($i = 0; $i < count($dev); $i++) {
			unset($a);
			unset($devline);
			if($dev[$i] == "eth1") {
				if(isset($msg0[0])) {
					$a = explode("=",trim($msg0[0]));
					$info[$i]["dev"] = $dev[$i];
					$info[$i]["ip"] = trim($a[2]);
					$info[$i]["name"] = "WAN1";
					if($a[1] == "OFF") {
						$info[$i]["connect"] = "down";
					} else {
						$info[$i]["connect"] = "up";
					}
					$info[$i]["link"] = get_ethlink($dev[$i]);
					if($a[1] == "OFF") {
						$ethflow = get_ethflow($dev[$i]);
					} else {
						$ethflow = get_ethflow($a[1]);
					}
					$info[$i]["rx_error"] = $ethflow["rx_error"];
					$info[$i]["tx_error"] = $ethflow["tx_error"];
					$info[$i]["collisions"] = $ethflow["collisions"];
				} else {
					$info[$i]["dev"] = "eth1";
					$info[$i]["ip"] = "OFF";
					$info[$i]["name"] = "WAN1";
					$info[$i]["connect"] = "down";
					$info[$i]["link"] = "no";
					$info[$i]["rx_error"] = 0;
					$info[$i]["tx_error"] = 0;
					$info[$i]["collisions"] = 0;
				}
			}else if($dev[$i] == "eth2") {
				foreach($msg0 as $line) {
					if(strstr($line, 'WAN2')) {
						$devline = $line;
					}
				}
				if(isset($devline)) {
					$a = explode("=",trim($devline));
					$info[$i]["dev"] = $dev[$i];
					$info[$i]["ip"] = trim($a[2]);
					$info[$i]["name"] = "WAN2";
					if($a[1] == "OFF") {
						$info[$i]["connect"] = "down";
					} else {
						$info[$i]["connect"] = "up";
					}
					$info[$i]["link"] = get_ethlink($dev[$i]);
					if($a[1] == "OFF") {
						$ethflow = get_ethflow($dev[$i]);
					} else {
						$ethflow = get_ethflow($a[1]);
					}
					$info[$i]["rx_error"] = $ethflow["rx_error"];
					$info[$i]["tx_error"] = $ethflow["tx_error"];
					$info[$i]["collisions"] = $ethflow["collisions"];
				}else {
					$info[$i]["dev"] = "eth2";
					$info[$i]["ip"] = "OFF";
					$info[$i]["name"] = "WAN2";
					$info[$i]["connect"] = "down";
					$info[$i]["link"] = "no";
					$info[$i]["rx_error"] = 0;
					$info[$i]["tx_error"] = 0;
					$info[$i]["collisions"] = 0;
				}
			}else if($dev[$i] == "eth0") {
				$info[$i]["dev"] = $dev[$i];
				
				$info[$i]["name"] = "LAN"; 
				$infolan = get_landev($dev[$i]);
				$info[$i]["ip"] = $infolan["ip"];
				$ethflow = get_ethflow($dev[$i]);

				$xx = get_ethlink($dev[$i]);
				$info[$i]["connect"] = ($xx == "yes") ? "up" : "down";
				$info[$i]["link"] = $xx;
				$info[$i]["rx_error"] = $ethflow["rx_error"];
				$info[$i]["tx_error"] = $ethflow["tx_error"];
				$info[$i]["collisions"] = $ethflow["collisions"];
			}else if($dev[$i] == "eth3") {
				$info[$i]["dev"] = $dev[$i];
				$info[$i]["name"] = "DMZ"; 
				$infolan = get_landev($dev[$i]);
				$info[$i]["ip"] = $infolan["ip"];
				$ethflow = get_ethflow($dev[$i]);

				$xx = get_ethlink($dev[$i]);
				$info[$i]["connect"] = ($xx == "yes") ? "up" : "down";
				$info[$i]["link"] = $xx;
				$info[$i]["rx_error"] = $ethflow["rx_error"];
				$info[$i]["tx_error"] = $ethflow["tx_error"];
				$info[$i]["collisions"] = $ethflow["collisions"];
			}
		}

		print_r($info);
	}

	// 查看開機與否和IP
	function get_landev($device) {
		$cmd1 = "cat /etc/sysconfig/network-devices/ifconfig.".$device."/ipv4";
		$cmd2 = "ifconfig ".$device;
		exec($cmd1, $msg1);
		exec($cmd2, $msg2);
		$info["onboot"] = trim(str_replace("ONBOOT=","",$msg1[0]));
		$devip = trim(str_replace("IP=","",$msg1[2]));
		if($devip == null || $devip == "#") $info["ip"] = "OFF";
		else $info["ip"] = $devip;
		return $info;
	}

	function listStringSplit($sList) {
		$aList = preg_split("/[\s,]+/", $sList , -1, PREG_SPLIT_NO_EMPTY);
		// -1沒有分割數量限制 PREG_SPLIT_NO_EMPTY只回傳非空白部份
		return $aList;
	}

	// 查看物理網路線有無接上 1表示有 Invalid argument表示關閉狀態
	function get_ethlink($dev) {
		exec("/bin/cat /sys/class/net/$dev/carrier", $retCont, $retCode);
		if($retCode == 0 && $retCont[0] == "1")	{
			return "yes";
		} else {
			return "no";
		}
	}

	// 查看是否順暢
	function get_ethflow($dev) {
		exec("/sbin/ifconfig $dev", $msg0);
		exec("/sbin/ip -s link show $dev",$msg1);

		$ethflow = array();

		$acoll = listStringSplit(trim($msg0[5])); // 應該是想抓collisions:0 但不同裝置的資料行數不一樣
		$acolli = explode(":",$acoll[0]);
		$collisions = $acolli[1];
		$ethflow["collisions"] = trim($collisions); // 碰撞情形

		// 查看rx和tx的error
		$arx = listStringSplit(trim($msg1[3]));
		$rxerror = trim($arx[2]); 
		$atx = listStringSplit(trim($msg1[5])); 
		$txerror = trim($atx[2]);  
		if(trim($rxerror)) $ethflow["rx_error"] = trim($rxerror);
		else $ethflow["rx_error"] = 0;
		if(trim($txerror)) $ethflow["tx_error"] = trim($txerror);
		else $ethflow["tx_error"] = 0;

		return $ethflow;
	}

	// 查看是否運行中
	// 如果dns的行程有出現在名單裡 代表正在運作
	function get_dns() {
		exec("ps aux | grep bind", $ret); // Process status 觀察運行中的行程 然後找到bind; a 顯示所有用戶的所有進程（包括其它用戶);u 按用戶名和啟動時間的順序來顯示進程;x 顯示無控制終端的進程
		// linux內建bind用於管理dns
		foreach((Array)$ret as $line) {
			$elt = split("[ \t]+", $line);
			if($elt[10] == "/PGRAM/bind/sbin/named") // 過濾查詢動作本身
				echo "running\n";
				return;
		}
		echo "not running\n";
		return;
	}

	// 查看cpu使用率
	function cpuloading() {
		$fd = fopen("/proc/stat", "r");
		if ($fd) {
			$statinfo = explode("\n", fgets($fd, 1024));
			fclose($fd);
			foreach($statinfo as $line) {
				$info = split(" +", $line);
				if ($info[0] == "cpu") {
					$user = $info[1];
					$nice = $info[2];
					$system = $info[3];
					$idle = $info[4];
					break;
				}
			}
		}
		$usage = $user + $nice + $system; // 已使用
		$total = $usage + $idle; // 等待中+已使用

		// 平均負載
		$fd = fopen("/proc/loadavg", "r");
		if ($fd) {
			$loadavg = fgets($fd, 1024);
			fclose($fd);
			list($oneminute, $fiveminute, $fifteenminute) = explode(' ', $loadavg);
			// 過去1、5、15分鐘內執行的平均行程數量 大於3可能有點問題
		}

		echo "$total, $usage, $oneminute, $fiveminute, $fifteenminute\n"; // 總共 使用率 1分鐘平均 5分鐘平均 15分鐘平均

	}

	// 查看硬碟使用狀況
	function hddinfo() {
	
		unset($disk_info);
		unset($ret);
		unset($info);

		// 找到硬碟
		exec("blkid", $searhdd);
		if($searhdd){
			for($i = 0; $i < count($searhdd); $i++){
				if(strpos($searhdd[$i], "HDD")){ // 找到有HDD的那行 /dev/hdb2: LABEL="HDD" UUID="ea7130b4-6819-489a-b6a3-cf7d5a3d7098" TYPE="ext3"
					$asearhdd = preg_split ("/[\s:]+/", $searhdd[$i]);
					$datadisk = trim($asearhdd[0]); // /dev/hdb2
				}
			}
		}

		// 查看使用量
		exec("df $datadisk -m | tail -n 1", $ret);
		$info = preg_split ("/[\s,]+/",$ret[0]);
		$diskinfo[all] = $info[1]; // 1M-blocks
		$diskinfo[used] = $info[2]; // Used
		$diskinfo[free] = $info[3]; // Available
		$diskinfo[percent] = $info[4]; // Use%

		$disk_info = $diskinfo[all].",".$diskinfo[free].",".$diskinfo[percent]."\n"; // 總共 剩餘 使用率 單位mb
		echo $disk_info;
	}

	// 查看記憶體
	function meminfo() {
		exec("free | grep \"Mem:\"", $msg); // 只查看實體記憶體 不看緩衝區
		$mem = split(" +", $msg[0]);
		$mem_all = round($mem[1]/1000, 2); // 預設單位是kb 除以1000轉mb 取小數後兩位
		$mem_free = round(($mem[3]+$mem[6])/1000, 2);
	
		if($mem_all > 3000 && $mem_all < 3200)
		{//Because the current kernel is 32-bit, it can only be caught 3G  memory size, AW-590
			$mem_all += 1000;
			$mem_free += 1000;
		}

		echo $mem_all.",".$mem_free."\n"; // 總共 剩餘 （單位mb)
	}


?>