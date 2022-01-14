<?php
require_once "DBconnect.php";

if(isset($_POST['add_record'])){
// 驗證

	// 必填和格式檢查
	$name_error = $gender_error = $phone_error = $birthday_error =
	$address_error = $email_error = "";

	$errors = array();
	$fill = 0;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST["new_name"])){
			$errors[] = 'Name: name is required!';
		}else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["new_name"])) {
				$errors[] = 'Name: name must be letters and white space.';
			}else{
				$name = strval($_POST["new_name"]);
				$fill++;
			}

		}

		if(empty($_POST["new_gender"])){
			$errors[] = 'Gender: gender is required!';
		}else{
			$gender = strval($_POST["new_gender"]);
			$fill++;
		}
		
		if(empty($_POST["new_phone"])){
			$errors[] = 'Phone: phone is required!';
		}else{
			if (!preg_match("/^09[0-9]{2}-([0-9]{6}|[0-9]{3}-[0-9]{3})$/",$_POST["new_phone"])) {
				$errors[] = 'Phone: phone must be numbers.';
			}else{
				$phone = strval($_POST["new_phone"]);
				$fill++;
			}
		}
		
		if(empty($_POST["new_birthday"])){
			$errors[] = 'Birthday: birthday is required!';
		}else{
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/",$_POST["new_birthday"])) {
				$errors[] = 'Birthday: birthday must be numbers.';
			}else{
				$birthday = strval($_POST["new_birthday"]);
				$fill++;
			}
		}

		if(empty($_POST["new_address"])){
			$errors[] = 'Address: address is required!';
		}else{
			if (!preg_match("/^[a-zA-Z-' \d]*$/",$_POST["new_address"])) {
				$errors[] = 'Address: address must be letters and punctuations.';
			}else{
				$address = strval($_POST["new_address"]);
				$fill++;
			}
		}
		
		if(empty($_POST["new_email"])){
			$errors[] = 'E-mail: e-mail is required!';
		}else{
			if (!filter_var($_POST["new_email"], FILTER_VALIDATE_EMAIL)) {
				$$errors[] = 'E-mail: invalid email format.';
			}else{
				$email = strval($_POST["new_email"]);
				$fill++;
			}
		}

		// 錯誤訊息
		if(isset($errors)){
			$message = implode('\n',$errors);
			echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
		}else{
			$sql = "UPDATE contact_list SET `name`='$name', `gender`='$gender', `phone`='$phone', 
			`birthday`='$birthday', `address`='$address', `email`='$email' WHERE `id`=$id";
	
			$result = mysqli_query($link,$sql);
	
			if (mysqli_affected_rows($link) > 0) {
			$new_id = mysqli_insert_id ($link);
			header('Location:./view/contact_list.php');
			}elseif(mysqli_affected_rows($link) == 0) {
			echo "Insert fail!";
			}else{
			echo "{$sql} Update fail!: " . mysqli_error($link);
			}
			
		}
		
	}

	mysqli_close($link); 

}