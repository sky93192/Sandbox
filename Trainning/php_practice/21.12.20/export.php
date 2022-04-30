<?php  

if(isset($_GET['export'])){
	if(file_exists('files/default.txt')){
		$file_url = 'files/default.txt';  
		header('Content-Type: application/octet-stream');  
		header("Content-Transfer-Encoding: utf-8");   
		header("Content-disposition: attachment; filename=\"" . "library_content_" . date('Y/m/d H:i:s') . ".txt". "\"");   
		readfile($file_url); 
	}else{
		echo "<script type='text/javascript'>alert('暫無資料');history.go(-1);</script>";
	}
	
}

?>