<?php
require_once "DBconnect.php";

if(isset($_POST['edit_record'])){
    // 驗證

	// 必填和格式檢查
	$name_error = $gender_error = $phone_error = $birthday_error =
	$address_error = $email_error = "";

	$errors = array();
	$fill = 0;

    if(empty($_POST["id_check"])){
        $id_error = 'Id is lost!';
        echo $id_error;
        var_dump($id);
    }else{
        $id = strval($_POST["id_check"]);
    }


	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(empty($_POST["edit_name"])){
			$errors[] = 'Name: name is required!';
		}else{
			if (!preg_match("/^[a-zA-Z-' ]*$/",$_POST["edit_name"])) {
				$errors[] = 'Name: name must be letters and white space.';
			}else{
				$name = strval($_POST["edit_name"]);
				$fill++;
			}

		}

		if(empty($_POST["edit_gender"])){
			$errors[] = 'Gender: gender is required!';
		}else{
			$gender = strval($_POST["edit_gender"]);
			$fill++;
		}
		
		if(empty($_POST["edit_phone"])){
			$errors[] = 'Phone: phone is required!';
		}else{
			if (!preg_match("/^09[0-9]{2}-([0-9]{6}|[0-9]{3}-[0-9]{3})$/",$_POST["edit_phone"])) {
				$errors[] = 'Phone: phone must be numbers.';
			}else{
				$phone = strval($_POST["edit_phone"]);
				$fill++;
			}
		}
		
		if(empty($_POST["edit_birthday"])){
			$errors[] = 'Birthday: birthday is required!';
		}else{
			if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/",$_POST["edit_birthday"])) {
				$errors['birthday_error'] = 'Birthday must be numbers.';
			}else{
				$errors[] = 'Birthday: birthday must be numbers.';
				$fill++;
			}
		}

		if(empty($_POST["edit_address"])){
			$errors[] = 'Address: address is required!';
		}else{
			if (!preg_match("/^[a-zA-Z-' \d]*$/",$_POST["edit_address"])) {
				$errors[] = 'Address: address must be letters and punctuations.';
			}else{
				$address = strval($_POST["edit_address"]);
				$fill++;
			}
		}
		
		if(empty($_POST["edit_email"])){
			$errors['email_error'] = 'Email is required!';
		}else{
			if (!filter_var($_POST["edit_email"], FILTER_VALIDATE_EMAIL)) {
				$errors[] = 'E-mail: invalid email format.';
			}else{
				$email = strval($_POST["edit_email"]);
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

}else{
    echo 'No value';
}

mysqli_close($link); 