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
		<label for="word">請輸入文字</label>
		<input type="text" name="word">
		<input type="submit"></button>
	</form>



<?php

if(isset($_POST['word'])){
	$str = $_POST['word'];
	
	function reverse_string($str){
		if(strlen($str)>0){
		reverse_string(substr($str,1));
		}
		echo substr($str,0,1);
		return;
		}
	
	
	echo reverse_string($str);
}

?>
</body>
</html>
