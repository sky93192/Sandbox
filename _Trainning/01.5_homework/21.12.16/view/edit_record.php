<?php
require_once "../DBconnect.php";

if(isset($_GET['id'])){
	$id = $link->real_escape_string($_GET['id']);
	$sql = "SELECT * FROM contact_list WHERE id=$id LIMIT 1";
	$result = mysqli_query($link, $sql);
	$info = mysqli_fetch_assoc($result);
	

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
			<h4>Edit Record</h4>
			<hr>
		</div>

		<!-- 內文 -->
		<div class="main">
			<form action="../edit.php" method="post">
				<!-- 表格 -->
				<table class="table">
					<tr>
						<td>Id</td>
						<td>
							<input type="hidden" name="id_check" disable="disable" value="<?php echo $info['id']; ?>"></input>
							<?php echo $info['id'];?>
						</td>
					</tr>

					<tr>
						<td>Name</td>
						<td>
							<input type="text" name="edit_name" value="<?= $info['name']; ?>" required placeholder="letters and white space only">
						</td>
					</tr>

					<tr>
					<td>Gender</td>
					<td>
						<?php
						if($info['gender'] == 'Male'){
							echo '
							<input type="radio" id="gender_male" name="edit_gender" value="Male" required checked>
							<label for="gender_male">Male</label>
							<input type="radio" id="gender_female" name="edit_gender" value="Female">
							<label for="gender_female">Female</label>';
						}else{
							echo'
							<input type="radio" id="gender_male" name="edit_gender" value="Male" required >
							<label for="gender_male">Male</label>
							<input type="radio" id="gender_female" name="edit_gender" value="Female" checked>
							<label for="gender_female">Female</label>';
						}
						?>
					</td>
					</tr>

					<tr>
						<td>Phone</td>
						<td>
							<input type="text" name="edit_phone" value="<?= $info['phone']; ?>" required placeholder="0987-654321">
						</td>
					</tr>

					<tr>
						<td>Birthday</td>
						<td>
							<input type="text" name="edit_birthday" value="<?= $info['birthday']; ?>" required placeholder="YYYY-MM-DD">
						</td>
					</tr>

					<tr>
						<td>Address</td>
						<td>
							<input type="text" name="edit_address" value="<?= $info['address']; ?>" required>
						</td>
					</tr>
					
					<tr>
						<td>E-mail</td>
						<td>
							<input type="text" name="edit_email" value="<?= $info['email']; ?>" required placeholder="example@mail.com">
						</td>
					</tr>

				</table>
		
				<hr>
				<a type="button" href="./contact_list.php" value="Back">Back</a>
				<input type="submit" name="edit_record" value="Edit Record">

			</form>

		</div>

	</div>
</body>
</html>

<?php
}
?>
