<?php 

$file = array();
$path = './files/default.txt';
if(file_exists($path)){
	$data = file($path);
}else{
	$data = array();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="./css/main.css">

	<title>Document</title>

</head>
<body>
	<div class="container">

		<!-- 標題 -->
		<div class="title">
			<h1>書籍管理系統</h1>
			<br>
		</div>

		<!-- 內文 -->
		<div class="main">
			<!-- 編輯檔案 -->
			<form action="upload.php" enctype="multipart/form-data" method="post">
				<span>匯入資料</span>
				<input type="file" name="upload_record">
  			<input type="submit" name="submit" value="Upload">
			</form>
			
			<form action="export.php">
				<span>匯出資料</span>
					<input type="submit" name="export" value="Export">
			</form>
			<br>
			<!-- 搜尋列 -->
			<form action="mainpage.php" method="post">
				<div class="search">
					<?php
					$option = '';
					if(isset($_POST['search_menu'])){
						$option = $_POST['search_menu'];

						$isbn = $publisher = $name = $author = $price = $release_date = array();
		
						foreach($data as $parts){
							$info = explode(',', $parts);
							// index0~5是資訊
							$isbn[] = $info['0'];
							$publisher[] = $info['1'];
							$name[] = $info['2'];
							$author[] = $info['3'];
							$price[] = $info['4'];
							$release_date[] = $info['5'];

						}

					}
					?>
					<span>排序</span>
					<select name="search_menu" id="search_menu">
					<option name="none" value="none">選擇排序...</option>
						<option name="publisher" value="publisher" <?= ($option == 'publisher')?'selected="selected"':'' ?> >出版社</option>
						<option name="name" value="name" <?= ($option == 'name')?'selected="selected"':'' ?> >書名</option>
						<option name="author" value="author" <?= ($option == 'author')?'selected="selected"':'' ?> >作者</option>
						<option name="price" value="price" <?= ($option == 'price')?'selected="selected"':'' ?> >定價</option>
						<option name="release_date" value="release_date" <?= ($option == 'release_date')?'selected="selected"':'' ?> >發行日</option>
					</select>

					<?php
					$direction = 'ASC';
					if(isset($_POST['direction'])){
						$direction = $_POST['direction'];

						if($option == 'publisher'){
							if($direction == "DESC"){
								arsort($publisher);
							}else{
								asort($publisher);
							}
							foreach($publisher as $key=>$val){
								$display[] = 
								array(
									'html' => 
									'<td>'. $isbn[$key]. '</td>'.
									'<td>'. $publisher[$key]. '</td>'.
									'<td>'. $name[$key]. '</td>'.
									'<td>'. $author[$key]. '</td>'.
									'<td>'. $price[$key]. '</td>'.
									'<td>'. $release_date[$key]. '</td>',

									'isbn' => $isbn[$key]
								);
							}

						}
						
						if($option == 'name'){
							if($direction == "DESC"){
								arsort($name);
							}else{
								asort($name);
							}
							foreach($name as $key=>$val){
								$display[] = 
								array(
									'html' => 
									'<td>'. $isbn[$key]. '</td>'.
									'<td>'. $publisher[$key]. '</td>'.
									'<td>'. $name[$key]. '</td>'.
									'<td>'. $author[$key]. '</td>'.
									'<td>'. $price[$key]. '</td>'.
									'<td>'. $release_date[$key]. '</td>',

									'isbn' => $isbn[$key]
								);
							}
						}

						if($option == 'author'){
							if($direction == "DESC"){
								arsort($author);
							}else{
								asort($author);
							}
							foreach($author as $key=>$val){
								$display[] = 
								array(
									'html' => 
									'<td>'. $isbn[$key]. '</td>'.
									'<td>'. $publisher[$key]. '</td>'.
									'<td>'. $name[$key]. '</td>'.
									'<td>'. $author[$key]. '</td>'.
									'<td>'. $price[$key]. '</td>'.
									'<td>'. $release_date[$key]. '</td>',

									'isbn' => $isbn[$key]
								);
							}
						}

						if($option == 'price'){
							if($direction == "DESC"){
								arsort($price);
							}else{
								asort($price);
							}
							foreach($price as $key=>$val){
								$display[] = 
								array(
									'html' => 
									'<td>'. $isbn[$key]. '</td>'.
									'<td>'. $publisher[$key]. '</td>'.
									'<td>'. $name[$key]. '</td>'.
									'<td>'. $author[$key]. '</td>'.
									'<td>'. $price[$key]. '</td>'.
									'<td>'. $release_date[$key]. '</td>',

									'isbn' => $isbn[$key]
								);
							}
						}

						if($option == 'release_date'){
							if($direction == "DESC"){
								arsort($release_date);
							}else{
								asort($release_date);
							}
							foreach($release_date as $key=>$val){
								$display[] = 
								array(
									'html' => 
									'<td>'. $isbn[$key]. '</td>'.
									'<td>'. $publisher[$key]. '</td>'.
									'<td>'. $name[$key]. '</td>'.
									'<td>'. $author[$key]. '</td>'.
									'<td>'. $price[$key]. '</td>'.
									'<td>'. $release_date[$key]. '</td>',

									'isbn' => $isbn[$key]
								);
							}
							
						}

					}
					
					?>
					<span>方向</span>
					<select name="direction" id="direction">
						<option name="ASC" value="ASC" <?= ($direction == 'ASC')?'selected="selected"':'' ?>>ASC</option>
						<option name="DESC" value="DESC" <?= ($direction == 'DESC')?'selected="selected"':'' ?>>DESC</option>
					</select>

					<input type="submit" name="sort" value="搜尋">
				</div>

				
			</form>
			
			<!-- 表格 -->
			<table class="table">
				<thead>
					<tr>
						<td>ISBN</td>
						<td>出版社</td>
						<td>書名</td>
						<td>作者</td>
						<td>定價</td>
						<td>發行日</td>
						<td>編輯/刪除</td>
					</tr>
				</thead>
				<tbody>

				<?php 
					if(count($data) <= 0 ){
						echo '<br><h2>查無資料</h2><br>';
					}else{
						if(!isset($display)){
							foreach($data as $parts){
								$info = explode(',', $parts);
								?>
								<tr>
									<td>
										<?= (isset($info['0']))?$info['0']:''; ?>
									</td>
									<td>
										<?= (isset($info['1']))?$info['1']:''; ?>
									</td>
									<td>
										<?= (isset($info['2']))?$info['2']:''; ?>
									</td>
									<td>
										<?= (isset($info['3']))?$info['3']:''; ?>
									</td>
									<td>
										<?= (isset($info['4']))?$info['4']:''; ?>
									</td>
									<td>
										<?= (isset($info['5']))?$info['5']:''; ?>
									</td>
									
										<td>
										<div class="row">
										<?php if(isset($info['0'])){
										echo' 
											<button type="button">
												<a type="button" href="add.php?isbn='. $info['0']. '" name="edit" value="Edit">Edit</a>
											</button>
											<button type="button">
												<a type="button" href="delete.php?isbn='. $info['0']. '" name="delete" value="Delete">Delete</a>
											</button>
										';
									} 
									?>
									</div>
									</td>
								</tr>
								<?php 
							}
						}else{
							foreach($display as $lines){
								?>
								<tr>
								<?= $lines['html']; ?>
								<?php if(!empty($lines['isbn'])){
									echo'
									<td>
										<div class="row">
											<button type="button">
												<a type="button" href="add.php?isbn='. $lines['isbn']. '" name="edit" value="Edit">Edit</a>
											</button>
											<button type="button">
												<a type="button" href="delete.php?isbn='. $lines['isbn']. '" name="delete" value="Delete">Delete</a>
											</button>
										</div>
									</td>';
								}
							}
						}
						?>
							</tr>
						<?php 
					}
			?>

				</tbody>
			</table>
			<br>
			<button type="button">
				<a type="button" href="add.php" name="add" value="add">ADD</a>
			</button>

		</div>

	</div>
</body>
</html>