<?php
require_once "./class/DBconnect.php";

/* 分頁顯示和搜尋排序 */
$sql = "SELECT * FROM `library_content`";
$result = $DB->query($sql);

// 每頁顯示筆數
$limit = 16;
$total_pages = ceil($DB->countrow($result) / $limit);

if(!isset($_GET['page']) || $_GET['page'] == null){
	$page = 1;
}else{
	$page = $_GET['page'];
	// 最大頁碼防呆
	if($page > $total_pages){
		$page = $total_pages;
	}
}

// 預設顯示排序
if(!isset($_POST['search_menu'])){
	$sort = 'isbn,ASC';
}else{
	$sort = $_POST['search_menu'];
}
$sort_result = explode(',',$sort);
$option = "$sort_result[0]";
$direction = "$sort_result[1]";

$current_page_result = ($page - 1) * $limit;
$page_sql = "SELECT * FROM `library_content` ORDER BY `$option` $direction LIMIT $current_page_result , $limit";
$page_result = $DB->query($page_sql);

// 列出項目
if($DB->countrow($page_result) <= 0){
	$s_no_record_message = '<h3>查無資料</h3>';
}else{
	$n_count = 0;
	while($a_book = $DB->fetch()){
		$a_isbn[] = $a_book['isbn'];
		$a_publisher[] = $a_book['publisher'];
		$a_book_name[] = $a_book['book_name'];
		$a_author[] = $a_book['author'];
		$a_price[] = $a_book['price'];
		$a_date[] = $a_book['release_date'];
		$n_count++;
	}
}

// 前後頁
$prev = ($page-1 < 1)?$page:$page-1;
$next = ($page+1 > $total_pages)?$page:$page+1;


/* 匯出 */
if(isset($_POST['export'])){
	// 印出已查完的內容
	if($n_count > 0){

		$a_export_data = array(
			array('ISBN', '出版社', '書名', '作者', '定價', '發行日')
		);
		for($i = 0; $i < $n_count; $i++){
			array_push($a_export_data, array($a_isbn[$i], html_entity_decode($a_publisher[$i]), html_entity_decode($a_book_name[$i]), 
			html_entity_decode($a_author[$i]), html_entity_decode($a_price[$i]), $a_date[$i]));
		}

		$fhandle = fopen('php://output', 'w');
		foreach ($a_export_data as $line) {
			fputcsv($fhandle, $line, ',');
		}
		fclose($fhandle);

		header("Content-type: application/octet-stream");
		header("Content-Transfer-Encoding: utf-8");
		header("Content-Disposition: attachment; filename=\"" . "library_content_" . date('Y/m/d H:i:s') . ".csv". "\"");
		header("Pragma: no-cache");
		header("Expires: 0"); 
	}else{
		echo "<script type='text/javascript'>alert('暫無資料');history.go(-1);</script>";
	}

	exit();	
}

/* 編輯按鈕跳轉 */
if(isset($_POST['edit'])){
	$isbn = $_POST['edit'];
	header('Location: add_and_edit.php?isbn='.$isbn);
	exit();	
}

/* 刪除 */
if(isset($_POST['selected_isbn'])){
	$s_selected_isbn = $_POST['selected_isbn'];
	// 是否存在
	$check_sql = "SELECT * FROM library_content WHERE `isbn`='$s_selected_isbn'";
	$check = $DB->query($check_sql);

	// 刪除
	if(!empty($check)){
		$sql = "DELETE FROM `library_content` WHERE `library_content`.`isbn`='$s_selected_isbn'";
		$delete_result = $DB->query($sql);
	}

	header('Location: index.php');

	exit();
}


include('./xhtml/index.html');


?>
