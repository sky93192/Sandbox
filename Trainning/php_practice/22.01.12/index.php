<?php
session_start();
require_once "./class/DBconnect.php";


/* 編輯按鈕跳轉 */
if(isset($_POST['edit'])){
	$isbn = $_POST['edit'];
	header('Location: add_and_edit.php?isbn='.$isbn);
	exit();	
}


/* 刪除 */
if($_SERVER["REQUEST_METHOD"] == 'POST'){
	
	if($_POST['action'] == 'delete'){
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

}


/* 分頁顯示和搜尋排序 */
$sql = "SELECT * FROM `library_content`";
$result = $DB->query($sql);

// 每頁顯示筆數
$limit = 16;
if($result !== false && $DB->countrow($result)){
	$total_pages = ceil($DB->countrow($result) / $limit);
	$display = true;
}else{
	$total_pages = 1;
	$display = false;
}


if(!isset($_GET['page']) || $_GET['page'] == null){
	$page = 1;
}else{
	// 最大頁碼防呆
	$page = min($_GET['page'], $total_pages);
}

// 預設排序
if(!isset($_POST['search_menu'])){
	if(!isset($_SESSION['last_sorting'])){
		$sort = 'isbn,ASC';
		$_SESSION['last_sorting'] = $sort;
	}else{
		$sort = $_SESSION['last_sorting'];
	}
}else{
	$sort = $_POST['search_menu'];
	$_SESSION['last_sorting'] = $sort;
}

$sort_result = explode(',',strval($_SESSION['last_sorting']));
$option = "$sort_result[0]";
$direction = "$sort_result[1]";

// 若有資料則顯示
if($display == true){
	$current_page_result = ($page - 1) * $limit;
	$page_sql = "SELECT * FROM `library_content` ORDER BY `$option` $direction LIMIT $current_page_result , $limit";
	$page_result = $DB->query($page_sql);

	// 列出項目
	$n_count = 0;
	while($a_book = $DB->fetch()){
		$a_book_row[] = array(
			'isbn' => $a_book['isbn'],
			'publisher' => $a_book['publisher'],
			'book_name' => $a_book['book_name'],
			'author' => $a_book['author'],
			'price' => $a_book['price'],
			'release_date' => $a_book['release_date']
		);
		$n_count++;
	}
	

	// 前後頁
	$prev = ($page-1 < 1)?$page:$page-1;
	$next = ($page+1 > $total_pages)?$page:$page+1;

	// tooltip資訊
	$tooltip_sql = "SELECT * FROM `publisher_info`";
	$tooltip_result = $DB->query($tooltip_sql);

	while($row = $DB->fetch($tooltip_result)){
		$publisher_info[$row['publisher']] = $row['phone'] . ' ' . $row['location'];
	}

}else{
	$s_no_record_message = '<td colspan="8">查無資料</td>';
}


/* 匯出 */
if($_SERVER["REQUEST_METHOD"] == 'POST'){

	if($_POST['action'] == 'export'){
		// 印出已查完的內容
		if($DB->countrow($result)){
			$a_export_data = array(
				array('ISBN', '出版社', '書名', '作者', '定價', '發行日')
			);
			// 印出全部
			if($_POST['export_part'] == "all"){

				$export_sql = "SELECT * FROM `library_content` ORDER BY `$option` $direction";
				
			// 印出整頁
			}elseif($_POST['export_part'] == "page"){
				
				$start = (intval($_POST['export_page']) - 1) * $limit;
				$export_sql = "SELECT * FROM `library_content` ORDER BY `$option` $direction LIMIT $start , $limit";

			// 印出選取
			}elseif($_POST['export_part'] == "selected"){
				if(isset($_POST['selected_book'])){

					if(count($_POST['selected_book']) > 1){
						$selected = implode("','", $_POST['selected_book']);
					}else{
						$selected = $_POST['selected_book'][0];
					}
					
					$export_sql = "SELECT * FROM `library_content` WHERE `isbn` IN (" . "'" . $selected . "'" . ") ORDER BY `$option` $direction";
					
				}else{
					echo "<script type='text/javascript'>alert('沒有選取項目');history.go(-1);</script>";
					exit();
				}
			}else{
				echo "<script type='text/javascript'>alert('請選擇匯出方式');history.go(-1);</script>";
				exit();
			}

			$export_result = $DB->query($export_sql);

			while($row = $DB->fetch($export_result)){
				array_push($a_export_data, array($row['isbn'], html_entity_decode($row['publisher']), html_entity_decode($row['book_name']), 
				html_entity_decode($row['author']), html_entity_decode($row['price']), $row['release_date']));
			}
			
			$fhandle = fopen('php://output', 'w');
			foreach ($a_export_data as $line) {
				fputcsv($fhandle, $line, ',');
			}
			fclose($fhandle);

			header("Content-type: application/octet-stream");
			header("Content-Transfer-Encoding: utf-8");
			header("Content-Disposition: attachment; filename=\"" . "library_content_" . date('Y_m_d H:i:s') . ".csv". "\"");
			header("Pragma: no-cache");
			header("Expires: 0");
		}else{
			echo "<script type='text/javascript'>alert('暫無資料');history.go(-1);</script>";
		}

		exit();	
	}

}

include('./xhtml/index.html');


?>
