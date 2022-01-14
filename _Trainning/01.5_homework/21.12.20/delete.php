<?php
if(isset($_GET['isbn'])){
	$file = './files/default.txt';
	$data = file($file);

	$old_isbn = $_GET['isbn'];
	foreach($data as $parts){
		$info = explode(',', $parts);
		$check_info[] = $info['0'];
	}

	if(!in_array($old_isbn, $check_info)){
		echo "<script type='text/javascript'>alert('紀錄不存在');window.location.href='mainpage.php';</script>";
	}else{
		// 刪除
		$fhandle = fopen('./files/default.txt', 'w+') or die ('無法開啟檔案');
		$edit_file = array();
		foreach($data as $line){
			$check_parts = explode(',', $line);
			if($old_isbn !== $check_parts['0']){
				$edit_file[] = trim($line);
			}
		}

		fwrite($fhandle, implode("\n", $edit_file));
		fclose($fhandle);
		echo "<script type='text/javascript'>alert('刪除成功！');window.location.href='mainpage.php';</script>";
		
	}

}