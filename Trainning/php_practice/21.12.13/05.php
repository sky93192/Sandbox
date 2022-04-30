<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<form action="./05.php" method="post">
    <label for="num">請輸入一個奇數:</label><br>
    <input type="text" id="start" name="start"><br>
	<input type="submit"></button>
</form>

<?php
if(isset($_POST['start'])){
	// 獲取輸入
	$n = $_POST['start'];

	function output($n){

        if((intval($n) % 2 == 0) || ($n == "")){
            echo "請輸入奇數";
            exit;
        }
            // set all slots as 0
        $magicSquare = array();
        for ($i = 0; $i < $n; $i++){
            for ($j = 0; $j < $n; $j++){
                $magicSquare[$i][$j] = 0;
            }
        }

        // Initialize position for 1
        $i = 0;
        $j = (int)$n / 2;

        // One by one put all values in
        // magic square
        for ($num = 1; $num <= $n * $n;){
            
            // 3rd condition
            if ($i == -1 && $j == $n){
                $j = $n-2;
                $i = 0;
            }else{
                // 1st condition helper if
                // next number goes to out
                // of square's right side
                if ($j == $n){
                    $j = 0;
                }
    
                // 1st condition helper if
                // next number is goes to
                // out of square's upper
                // side
                if ($i < 0){
                    $i = $n-1;
                }
            }
            
            // 2nd condition
            if ($magicSquare[$i][$j]){
                $j -= 2;
                $i++;
                continue;
            }else{
                // set number
                $magicSquare[$i][$j] = $num++;
            }
            // 1st condition
            $j++; $i--;
        }
    
        // Print magic square
        echo "這是 n = ". $n. "的魔方陣<br>每行或列的總和是: ". $n * ($n * $n + 1) / 2;
        echo "<br>";

        for ($i = 0; $i < $n; $i++){
            for ($j = 0; $j < $n; $j++){
                echo $magicSquare[$i][$j] . " ";
            }
            echo "<br>";
        }
	}

output($n);
     
// This code is contributed by mits.
}

?>
</body>
</html>