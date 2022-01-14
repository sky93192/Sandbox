<?php
require_once "./class/DBconnect.php";
/**載入頁面 */
if(isset($_GET['add']) || isset($_GET['isbn'])){
	if(isset($_GET['add'])){
		$title = '新增紀錄';
	}else{
		$title = '修改紀錄';
		$isbn = $_GET['isbn'];
		$edit_sql = "SELECT * FROM `library_content` WHERE `isbn`='$isbn'";
		$edit_result = $DB->query($edit_sql);
		$colum = $DB->fetch($edit_result);
	}
	include('./xhtml/add_and_edit.html');

/** 收到表單後動作 */
}elseif(isset($_POST['edit_record']) || isset($_POST['add_record'])){

	/** 內容驗證 */
	if(isset($_POST["old_isbn"])){
		$isbn = strval($_POST["old_isbn"]);
	}else{
		if(empty($_POST["new_isbn"])){
			$errors[] = 'ISBN: 請填寫ISBN';
		}else{
			if (!preg_match("/([0-9]{3}-?){3,4}-?[0-9]$/",$_POST["new_isbn"])) {
				$errors[] = 'ISBN: ISBN必須為數字及-號';
			}else{
				$isbn = mysql_real_escape_string(strval($_POST["new_isbn"]));
				$check_sql = "SELECT * FROM `library_content` WHERE `isbn`='$isbn'";
				$check_result = $DB->query($check_sql);
				if($DB->countrow($check_result) !== 0){
					$errors[] = 'ISBN: 此ISBN已存在';
				}
			}
		}
	}

	if(empty($_POST["new_publisher"])){
		$errors[] = 'Publisher: 請填寫出版社';
	}else{
		if (preg_match("/(\n|,)/",$_POST["new_publisher"])) {
			$errors[] = 'Publisher: 出版社必須為文字或數字';
		}else{
			$publisher = mysql_real_escape_string(htmlentities(strval($_POST["new_publisher"])));
		}

	}

	if(empty($_POST["new_book_name"])){
		$errors[] = 'Name: 請填寫書名';
	}else{
		if (preg_match("/(\n|,)/",$_POST["new_book_name"])) {
			$errors[] = 'Name: 書名必須為文字或數字';
		}else{
			$book_name = mysql_real_escape_string(htmlentities(strval($_POST["new_book_name"])));
		}

	}

	if(empty($_POST["new_author"])){
		$errors[] = 'Author: 請填寫作者';
	}else{
		if (preg_match("/(\n|,)/",$_POST["new_author"])) {
			$errors[] = 'Author: 作者姓名必須為文字或數字';
		}else{
			$author = mysql_real_escape_string(htmlentities(strval($_POST["new_author"])));
		}

	}

	if(!isset($_POST["new_price"])){
		$errors[] = 'Price: 請填寫定價';
	}else{
		if (!preg_match("/^[0-9]+$/",$_POST["new_price"])) {
			$errors[] = 'Price: 定價必須為數字';
		}else{
			$price = mysql_real_escape_string(htmlentities(strval($_POST["new_price"])));
		}

	}

	if(empty($_POST["new_release_date"])){
		$errors[] = 'Release Date: 請填寫發行日';
	}else{
		if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/",$_POST["new_release_date"])) {
			$errors[] = 'Release date: 發行日必須為西元年月日';
		}else{
			$release_date = mysql_real_escape_string(strval($_POST["new_release_date"]));
		}

	}
	
	/* 編輯 新增 */
	if(isset($errors)){
		$message = implode("\n",$errors);
		echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
		exit();
	}else{

		if(isset($_POST['edit_record'])){
			// 編輯
			$sql = "UPDATE `library_content` SET `isbn`='$isbn', `publisher`='$publisher', `book_name`='$book_name', 
			`author`='$author', `price`='$price', `release_date`='$release_date' WHERE `isbn`='$isbn'";
			$message = '編輯成功！';
	
		}elseif(isset($_POST['add_record'])){
			// 新增
			$sql = "INSERT INTO `library_content` (`isbn`, `publisher`, `book_name`, `author`, `price`, `release_date`) 
			VALUES ('$isbn', '$publisher', '$book_name', '$author', '$price', '$release_date')";
			$message = '新增成功！';
		}
	
		$result = $DB->query($sql);
		echo "<script type='text/javascript'>alert('$message');window.location.href='index.php';</script>";
		$DB->close_con();
		exit();

	}

}


?>