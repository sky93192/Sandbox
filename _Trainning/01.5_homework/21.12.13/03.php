<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		<input type="text" name="lights">
		<label for="lights">盞燈</label>
		<input type="text" name="people">
		<label for="people">個人</label>
		<input type="submit"></button>
		<h3>說明：「。」代表開燈，「x」代表關燈</h3>
	</form>
	
<?php
if(isset($_POST['lights']) && isset($_POST['people'])){
	$n = $_POST['lights'];
	$k = $_POST['people'];
	echo $n.'盞燈，'.$k.'個人按開關：';

	function light_switch($n, $k){
		$result = array();
		// $result = new SplFixedArray($n);
		// 初始化燈
		for($s = 1; $s <= $n; $s++){
			$result[$s] = false;
			var_dump($s);
		}
		// var_dump($result);
		// 儲存燈的狀態

		// 開關燈
		for($i = 1; $i < (count($result)+1); $i++){
			for($j = 1; $j < ($k+1); $j++){
				if(($i%$j == 0)){
					$result[$i] = !$result[$i];
				}
			}
		}

		// 印出燈
		foreach($result as $switch){
			if($switch){
				echo '。';
			}else{
				echo 'X';
			}
			// var_dump($switch);
		}
		
	}
	
	light_switch($n, $k);
}

?>
</body>
</html>