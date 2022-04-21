<?
class Port
{
	function getv($key) {
		$aPortSet = parse_ini_file("port.conf");
		return $aPortSet[$key];
		// $aPortSet[LANs] = 2, $aPortSet[WAN] = 4
	}

	function get_port_dev(){
		$port_dev_info_file = "60-myorder.rules";
		if(file_exists($port_dev_info_file)){
			$port_dev_info = file($port_dev_info_file);
			foreach($port_dev_info as $key => $line){
				// 0 => SUBSYSTEM=="net", DRIVERS=="e1000e", KERNELS=="0000:03:00.0", ATTRS{local_cpus}=="1", ATTRS{local_cpulist}=="0", NAME="eth01"
				// 1 => SUBSYSTEM=="net", DRIVERS=="e1000e", KERNELS=="0000:02:00.0", ATTRS{local_cpus}=="1", ATTRS{local_cpulist}=="0", NAME="eth3"
				$line = trim($line);
				$msg = explode(",", $line);
				$i = $key;
				if($this->getv("WAN") == 4) { // 整理key的順序
					if(1 == $key){
						$i = 3; //dmz $aPortSet[WAN] = 4
					}
					if(2 == $key){
						$i = 1; //wan3
					}
					if(3 == $key){
						$i = 2; //wan4
					}

					// LANs
				}else if(2 == $key){
					break;
				}

				// 60-myorder.rules 的 name 欄位
				preg_match("/NAME=\"(eth([2-9]|0[1-9]))\"/", $msg[5], $name);
				switch($name[1]){
					case "eth2":
						$aPortDev[$i] = "W2";
						break;
					case "eth3":
						$aPortDev[$i] = "L2"; // $aPortDev[3] = L2
						break;
					case "eth4":
						$aPortDev[$i] = "W3";
						break;
					case "eth5":
						$aPortDev[$i] = "W4";
						break;
					case "eth6":
						$aPortDev[$i] = "W5";
						break;
					case "eth01":
						$aPortDev[$i] = "L1A";
						break;
					case "eth02":
						$aPortDev[$i] = "L1B";
						break;
					case "eth03":
						$aPortDev[$i] = "L1C";
						break;
				}
			}
		}

		// 預設值，如果60-myorder.rules 的 name 欄位沒有第二組
		if(empty($aPortDev)){
			$aPortDev[] = "W2";
			if($this->getv("WAN") == 4) {
				$aPortDev[] = "W3";
				$aPortDev[] = "W4";
			}
			$aPortDev[] = "L2";
			if($this->getv("LANs") == 2) {
				$aPortDev[] = "L1A";
				$aPortDev[] = "L1B";
			}
		}
		return $aPortDev;
	}
}

?>
