<?php
session_start();

// 檢查session
if(!isset($_SESSION['Answer'])){
	// 產生答案
	$start = array(0,1,2,3,4,5,6,7,8,9);
	$answer = array_rand($start, 4);

	// 儲存答案
	$_SESSION['Answer'] = $answer;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>

<form action="" method="get" id="game">
	<label for="num">請輸入數字:</label><br>
  <input type="text" id="num" name="num" ><br>
	<input type="button" id="button" value="guess"></button>
	<p type="hidden" id="message" name="message"></p>
</form>

<?php
if(isset($_GET['num'])){
	// 獲取輸入
	$submit = $_GET['num'];
	$guess = strval($_GET['num']);

	function get_guess($guess){
		// 初始化ab
		$A = 0;
		$B = 0;

		// $guess拆成4個數字
/* 		$arr_guess = preg_split('//', $guess, -1, PREG_SPLIT_NO_EMPTY);

		if($arr_guess !== $answer){
			echo '輸入：'.$guess.'<br>';
			// 和$answer比較
			for($j = 0; $j < count($answer); $j++){
				if($arr_guess[$j] == $answer[$j]){
					$A++;
				}elseif(in_array($arr_guess[$j], $answer) && (array_keys($arr_guess,[$j]) != array_keys($answer,[$j]))){
					$B++;
				}
				// 答對
				if($arr_guess === $answer){
					echo '答對了，是'.$arr_guess;
					session_destroy();
				}
			}
			echo $A.'A'.$B.'B';
		} */
	}
	get_guess($submit);
}

?>

</body>
</html>