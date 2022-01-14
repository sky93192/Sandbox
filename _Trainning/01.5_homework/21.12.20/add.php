<?php 

$path = './files/default.txt';
if(file_exists($path)){
	$data = file($path);
}else{
	$data = array();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="./css/main.css">

	<title>Document</title>

	<style>
		table {
			border-spacing: 0;
			width: 20%;
		}
	</style>

</head>
<body>
	<div class="container">

		<!-- 標題 -->
		<div class="title">
			<h1>書籍管理系統</h1>
			<br>
			<?php
			if(!isset($_GET['isbn'])){
				echo '<h4>新增紀錄</h4>';
			}else{
				echo '<h4>修改紀錄</h4>';

				$info['0'] = $_GET['isbn']; // 整筆資料
				
				foreach($data as $line){
					if(stripos($line, $info['0']) !== false ){ // ?
						$info = explode(',', $line);
					}
				}
			}
			
			?>
			
		</div>

		<!-- 內文 -->
		<div class="main">
			<form action="add.php" method="post">
							<!-- 表格 -->
				<table class="table">
						<tr>
							<td>ISBN</td>
							<td>
								<input type="text" id="new_isbn" name="new_isbn" value="<?= (isset($info))?$info['0']:''; ?>" required placeholder="000-000-000-0">
								<?php
								if(isset($info['0'])){
									echo '<input type="text" id="old_isbn" name="old_isbn" value="'.$info['0'],'" hidden>';
								}
								?>
							</td>
						</tr>

						<tr>
							<td>出版社</td>
							<td>
								<input type="text" id="new_publisher" name="new_publisher" value="<?= (isset($info['1']))?$info['1']:''; ?>" required placeholder="請輸入文字">
							</td>
						</tr>

						<tr>
							<td>書名</td>
							<td>
								<input type="text" id="new_name" name="new_name" value="<?= (isset($info['2']))?$info['2']:''; ?>" required placeholder="請輸入文字">
							</td>
						</tr>

						<tr>
							<td>作者</td>
							<td>
								<input type="text" id="new_author" name="new_author" value="<?= (isset($info['3']))?$info['3']:''; ?>" required placeholder="請輸入文字">
							</td>
						</tr>

						<tr>
							<td>定價</td>
							<td>
								<input type="text" id="new_price" name="new_price" value="<?= (isset($info['4']))?$info['4']:''; ?>" required placeholder="請輸入數字">
							</td>
						</tr>
						
						<tr>
							<td>發行日</td>
							<td>
								<input type="text" id="new_release_date" name="new_release_date" value="<?= (isset($info['5']))?$info['5']:''; ?>" required placeholder="YYYY-MM-DD">
							</td>
						</tr>

				</table>
				<br>
				<button type="button">
					<a type="button" href="mainpage.php" value="Back">返回主頁</a>
				</button>
				<?php if(isset($info['0'])){
					echo '<button type="button"><input type="submit" name="edit_record" value="Edit Record"></button>';
				}else{
					echo '<button type="button"><input type="submit" name="add_record" value="Add Record"></button>';
				} 
				?>
				

			</form>

		</div>

	</div>
</body>
</html>

<?php

}else{
	// 驗證

	// 必填和格式檢查
	
	if(empty($_POST["new_isbn"])){
		$errors[] = 'ISBN: ISBN is required!';
	}else{
		if (!preg_match("/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/",$_POST["new_isbn"])) {
			$errors[] = 'ISBN: ISBN must be numbers';
		}else{
			// default不為空
			// if(!empty($data)){
			// 	// 編輯
			// 	if(isset($_POST["old_isbn"])){
			// 		// isbn更改
			// 		if($_POST["old_isbn"] !== $_POST["new_isbn"]){
			// 			foreach($data as $line){
			// 				$isbn_check = explode(',', $line);
			// 				if($isbn_check[0] === $_POST["new_isbn"]){
			// 					$errors[] = 'ISBN: This ISBN has existed';
			// 				}else{
			// 					$isbn = strval($_POST["new_isbn"]);
			// 				}
			// 			}
			// 		}else{
			// 			// isbn未更改
			// 			$isbn = strval($_POST["new_isbn"]);
			// 		}
			// 	}else{
			// 		// 新增
			// 		foreach($data as $line){
			// 			$isbn_check = explode(',', $line);
			// 			if($isbn_check[0] === $_POST["new_isbn"]){
			// 				$errors[] = 'ISBN: This ISBN had existed';
			// 			}else{
			// 				$isbn = strval($_POST["new_isbn"]);
			// 			}
			// 		}
			// 	}
			// }else{
			// 	// default為空
			// 	// 新增
			// 	$isbn = strval($_POST["new_isbn"]);
			// }
			$isbn = strval($_POST["new_isbn"]);
			// 新增 或 編輯改變了isbn
			if(!isset($_POST["old_isbn"]) || $_POST["old_isbn"] !=  $isbn){
				foreach($data as $line){
					$isbn_check = explode(',', $line);
					if($isbn_check[0] ===  $isbn){
						$errors[] = 'ISBN: This ISBN had existed';
						break;
					}
				}
			}
		}
	}

	

	if(empty($_POST["new_publisher"])){
		$errors[] = 'Publisher: publisher is required!';
	}else{
		if (preg_match("/(\n|,)/",$_POST["new_publisher"])) {
			$errors[] = 'Publisher: publisher must be letters';
		}else{
			$publisher = strval($_POST["new_publisher"]);
		}

	}

	if(empty($_POST["new_name"])){
		$errors[] = 'Name: name is required!';
	}else{
		if (preg_match("/(\n|,)/",$_POST["new_name"])) {
			$errors[] = 'Name: name must be letters';
		}else{
			$name = strval($_POST["new_name"]);
		}

	}

	if(empty($_POST["new_author"])){
		$errors[] = 'Author: author is required!';
	}else{
		if (preg_match("/(\n|,)/",$_POST["new_author"])) {
			$errors[] = 'Author: author must be letters';
		}else{
			$author = strval($_POST["new_author"]);
		}

	}

	if(empty($_POST["new_price"])){
		$errors[] = 'Price: price is required!';
	}else{
		if (!preg_match("/^[0-9]+$/",$_POST["new_price"])) {
			$errors[] = 'Price: price must be numbers';
		}else{
			$price = strval($_POST["new_price"]);
		}

	}

	if(empty($_POST["new_release_date"])){
		$errors[] = 'Release Date: release date is required!';
	}else{
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/",$_POST["new_release_date"])) {
			$errors[] = 'Release date: release date must be numbers';
		}else{
			$release_date = strval($_POST["new_release_date"]);
		}

	}
	

	// 錯誤訊息
	if(isset($errors)){
		$message = implode('\n',$errors);
		echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
	}else{
		// 編輯紀錄
		if(isset($_POST['edit_record'])){

			$old_isbn = $_POST["old_isbn"];
			foreach($data as $parts){
				$info = explode(',', $parts);
				$check_info[] = $info['0'];
			}
			if(!in_array($old_isbn, $check_info)){
				echo "<script type='text/javascript'>alert('紀錄不存在');window.location.href='mainpage.php';</script>";
			}else{
				$fhandle = fopen('./files/default.txt', 'w+') or die ('系統錯誤');
				$edit_string = $isbn. ','. $publisher. ','. $name. ','. $author. ','. $price. ','. $release_date. "\n";
				// 全部覆寫
				// 複製舊檔
				$edit_file = array();
				foreach($data as $line){
					$check_parts = explode(',', $line);
					// 檢查isbn
					if($old_isbn == $check_parts['0']){
						$edit_file[] = $edit_string;
					}else{
						$edit_file[] = $line;
					}
				}
				
				// 清掉最後的換行
				fwrite($fhandle, trim(implode("", $edit_file)));
				fclose($fhandle);
				echo "<script type='text/javascript'>alert('編輯成功！');window.location.href='mainpage.php';</script>";
			}
			
		}else{
			// 新增紀錄
			$fhandle = fopen('./files/default.txt', 'a') or die ('系統錯誤');
			if(empty($data)){
				$string_data = $isbn. ','. $publisher. ','. $name. ','. $author. ','. $price. ','. $release_date;
			}else{
				$string_data = "\n". $isbn. ','. $publisher. ','. $name. ','. $author. ','. $price. ','. $release_date;
			}
			
			fwrite($fhandle, $string_data);
			fclose($fhandle);
			echo "<script type='text/javascript'>alert('新增成功！');window.location.href='mainpage.php';</script>";
		}

	}
	
} 