<?php
require_once "../add.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/edit.css">

	<title>Document</title>
</head>
<body>
	<div class="container">

		<!-- 標題 -->
		<div class="title">
			<h1>Contact List</h1>
			<h4>Add Record</h4>
			<hr>
		</div>

		<!-- 內文 -->
		<div class="main">
			<form action="../add.php" method="post">
							<!-- 表格 -->
				<table class="table">
						<tr>
							<td>Name</td>
							<td>
								<input type="text" id="new_name" name="new_name" required placeholder="letters and white space only">
							</td>

						</tr>

						<tr>
						<td>Gender</td>
						<td>
							<input type="radio" id="gender_male" name="new_gender" value="Male" required>
							<label for="gender_male">Male</label>
							<input type="radio" id="gender_female" name="new_gender" value="Female">
							<label for="gender_female">Female</label>
						</td>
						</tr>

						<tr>
							<td>Phone</td>
							<td>
								<input type="text" id="new_phone" name="new_phone" required placeholder="0987-654321">
							</td>
						</tr>

						<tr>
							<td>Birthday</td>
							<td>
								<input type="text" id="new_birthday" name="new_birthday" required placeholder="YYYY-MM-DD">
							</td>
						</tr>

						<tr>
							<td>Address</td>
							<td>
								<input type="text" id="new_address" name="new_address" required>
							</td>
						</tr>
						
						<tr>
							<td>E-mail</td>
							<td>
								<input type="text" id="new_email" name="new_email" required placeholder="example@mail.com">
							</td>
						</tr>

				</table>
		
				<hr>
				<a type="button" href="./contact_list.php" value="Back">Back</a>
				<input type="submit" value="Add Record" name="add_record">

			</form>

		</div>

	</div>
</body>
</html>
