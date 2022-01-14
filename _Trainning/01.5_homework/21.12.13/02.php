<?php


if(!isset($_SESSION['Answer'])){
	// 產生答案
	$start = array(0,1,2,3,4,5,6,7,8,9);
	$answer = array_rand($start, 4);

	// 儲存答案
	session_start();
	$_SESSION['Answer'] = $answer;
}
?>


<?
if(isset($_POST['num']) == false){?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<title>Document</title>

	<script>
		$(document).ready(function(){
			$("#button").click(function(){
				$.ajax({
					type: 'post',
					url: '02.php',
					dataType: 'html',
					success: function(result){
						$("#guess").text(result);
					}
				})
			})
		})

	</script>

</head>
<body>

<form action="02.php" method="post" id="game">
	<label for="num">請輸入數字:</label><br>
  <input type="text" id="num" name="num" ><br>
	<input type="button" id="button" value="guess"></button>
	<p id="guess" name="guess">猜！</p>
	<p type="hidden" id="message" name="message"></p>
</form>
</body>
</html>

<?}
?>


<?php
if(isset($_POST['num'])){
	// 獲取輸入
	$submit = $_POST['num'];
	$guess = strval($_POST['num']);

	function get_guess($guess){
		// 初始化ab
		$A = 0;
		$B = 0;

		// $guess拆成4個數字
		$arr_guess = preg_split('//', $guess, -1, PREG_SPLIT_NO_EMPTY);

		if($arr_guess !== $_SESSION['Answer']){
			echo '輸入：'.$guess.'<br>';
			// 和$_SESSION['Answer']比較
			for($j = 0; $j < count($_SESSION['Answer']); $j++){
				if($arr_guess[$j] == $_SESSION['Answer'][$j]){
					$A++;
				}elseif(in_array($arr_guess[$j], $_SESSION['Answer']) && (array_keys($arr_guess,$arr_guess[$j]) != array_keys($_SESSION['Answer'],$_SESSION['Answer'][$j]))){
					$B++;
				}
				// 答對
				if($arr_guess === $_SESSION['Answer']){
					echo '答對了，是'.$arr_guess;
					session_destroy();
				}
			}
			echo $A.'A'.$B.'B';
		}
	}
	get_guess($submit);
}

?>