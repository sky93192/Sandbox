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
		<label for="number">請輸入數字</label>
		<input type="text" name="number">
		<label for="count">請輸入列數</label>
		<input type="text" name="count">
		<input type="submit"></button>
	</form>
<?php
if(isset($_POST['number']) && ($_POST['count'])){
	$n = $_POST['number'];
	$c = $_POST['count'];
	
	function print_number($n, $c){
		$result = array($n);
		for($i = 0; $i < $c; $i++){
			echo implode('', $result).'&nbsp<br>';
			$result[0] -= 7;
	
			for($j = 0; $j <= 2*$i+2; $j++){
				$result[$j] = $result[0] + 10*$j;
			}
			// var_dump($result);
			// echo '<br>';
		}
	}
	
	echo print_number($n, $c);
}

?>

</body>
</html>