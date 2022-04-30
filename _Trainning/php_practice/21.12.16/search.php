<?php
require_once "DBconnect.php";

$datas = array();

if(isset($_POST['search_menu'])){
	$option = $_POST['search_menu'];
}

if(isset($_POST['search_keywords'])){
	if(!preg_match("^(.+)\\sand\\s(.+)|(.+)\\sor(.+)\\s$",$_POST['search_keywords'])){
		$keyword = $_POST['search_keywords'];
	}else{
		echo 'Invalid words.';
	}
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
			<h1>Contact List</h1>
			<h4>List View</h4>
			<hr>
		</div>

		<!-- 內文 -->
		<div class="main">
			<!-- 搜尋列 -->
			<form action="search.php" method="post">
				<div class="search">
					<span>Search:</span>
					<select name="search_menu" id="search_menu" >
						<option name="name" value="name" <?= ($option == 'name')?'selected="selected"':'' ?>>Name</option>
						<option name="gender" value="gender" <?= ($option == 'gender')?'selected="selected"':'' ?>>Gender</option>
						<option name="phone" value="phone" <?= ($option == 'phone')?'selected="selected"':'' ?>>Phone</option>
						<option name="birthday" value="birthday" <?= ($option == 'birthday')?'selected="selected"':'' ?>>Birthday</option>
						<option name="address" value="address" <?= ($option == 'address')?'selected="selected"':'' ?>>Address</option>
						<option name="email" value="email" <?= ($option == 'email')?'selected="selected"':'' ?>>E-mail</option>
					</select>
					<input type="text" id="search_keywords" name="search_keywords" value="<?= $keyword ?>">
					<input type="submit" class="button" name="search" value="Search">
					<div>
					<?php
						echo '<h4>Results of searching:</h4>'. $keyword.' in '.  $option. '...';
					?>
					</div>
			</form>
				<br>
			</div>

			<!-- 表格 -->
			<table class="table">
				<thead>
					<tr>
						<td>Id</td>
						<td>Name</td>
						<td>Gender</td>
						<td>Phone</td>
						<td>Birthday</td>
						<td>Address</td>
						<td>E-mail</td>
						<td>Edit/Delete</td>
					</tr>
				</thead>
				<tbody>
					<?php
						$sql = "SELECT * FROM contact_list WHERE `$option` LIKE '%$keyword%'";
						$result = mysqli_query($link, $sql);
						$result_check = mysqli_num_rows($result);

						if($result_check <= 0){
							echo '<h4>No record found</h4>';
						}else{
							$count = 1;
							while($row = mysqli_fetch_assoc($result)){
								$datas[] = $row;
								$count++;
							?>
							<tr>
								<td>
									<?php echo $row['id']; ?>
								</td>
								<td>
									<?php echo $row['name']; ?>
								</td>
								<td>
									<?php echo $row['gender']; ?>
								</td>
								<td>
									<?php echo $row['phone']; ?>
								</td>
								<td>
									<?php echo $row['birthday']; ?>
								</td>
								<td>
									<?php echo $row['address']; ?>
								</td>
								<td>
									<?php echo $row['email']; ?>
								</td>
								<td>
								<div class="row">
									<a type="button" href="./view/edit_record.php?id=<?= $row['id'] ?>" name="edit" value="Edit">Edit</a>
									<a type="button" href="./delete.php?id=<?= $row['id'] ?>" name="delete" value="Delete">Delete</a>
								</div>
								</td>
							</tr>
						<?php
						}
					}
					?>
				</tbody>
			</table>
		
			<hr>

			<a type="button" href="./view/contact_list.php" name="add_record" value="Back to List">Back to List</a>

		</div>

	</div>
</body>
</html>