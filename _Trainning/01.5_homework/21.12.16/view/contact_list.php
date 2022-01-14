<?php
require_once "../DBconnect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="../css/main.css">

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
			<form action="../search.php" method="post">
				<div class="search">
					<span>Search:</span>
					<select name="search_menu" id="search_menu">
						<option name="name" value="name">Name</option>
						<option name="gender" value="gender">Gender</option>
						<option name="phone" value="phone">Phone</option>
						<option name="birthday" value="birthday">Birthday</option>
						<option name="address" value="address">Address</option>
						<option name="email" value="email">E-mail</option>
					</select>
					<input type="text" id="search_keywords" name="search_keywords">
					<input type="submit" class="button" name="search" value="Search">
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
						$datas = array();
						$sql_all = "SELECT * FROM contact_list ORDER BY id";
						$result_all = mysqli_query($link, $sql_all);
						$result_check = mysqli_num_rows($result_all);

						if($result_check <= 0){
							echo '<h4>No record found</h4>';
						}else{
							$count = 1;
							while($row = mysqli_fetch_assoc($result_all)){
								$count++
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
									<a type="button" href="./edit_record.php?id=<?= $row['id'] ?>" name="edit" value="Edit">Edit</a>
									<a type="button" href="../delete.php?id=<?= $row['id'] ?>" name="delete" value="Delete">Delete</a>
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

			<a type="button" href="./add_record.php" name="add_record" value="Add Record">Add Record</a>

		</div>

	</div>
</body>
</html>