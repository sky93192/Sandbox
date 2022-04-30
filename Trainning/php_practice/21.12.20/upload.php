<?php

if(isset($_POST['submit'])){
  $file = $_FILES['upload_record'];

  $file_name = $_FILES['upload_record']['name'];
  $file_tmp_name = $_FILES['upload_record']['tmp_name'];
  $file_size = $_FILES['upload_record']['size'];
  $file_error = $_FILES['upload_record']['error'];
  $file_type = $_FILES['upload_record']['type'];

  // 取得副檔名
  $file_extension = explode('.', $file_name);
  $file_actual_ext = strtolower(end($file_extension));

  // 檢查格式
  if($file_error === 0){
    $allowed = array('txt');
    if(in_array($file_actual_ext, $allowed)){
      $file_read = fopen("$file_tmp_name", 'r');
      if(file_exists('./files/default.txt')){
        $file_origin = file('./files/default.txt'); // array 裡面放書的string
      }else{
        $file_origin = array();
      }
      

      // 閱讀上傳內容
      while (!feof($file_read)) {
        $upload_value = trim(fgets($file_read)); // string
        $lines = explode(',',$upload_value); // 欄位拆開 每行是一個array

        // 內容檢查
        $writing_error = 0;
        foreach($file_origin as $parts){
          $colum = explode(',', $parts);
          $check_parts = $colum[0];
          // 檢查isbn
          if($lines[0] == $check_parts){
            $writing_error++;
          }
        }
        
        if($writing_error > 0){
          fclose($file_read);
          echo "<script type='text/javascript'>alert('檔案內容已存在，請檢查內容');history.go(-1);</script>";
          exit;
        }else{
          
          // 欄位數檢查
          if(count($lines) !== 6 ){
            echo count($lines);
            echo "<script type='text/javascript'>alert('檔案內容格式錯誤，請檢查欄位是否正確填寫');history.go(-1);</script>";
            exit;
          }else{
            // 內容驗證
            if (!preg_match("/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/",$lines[0])) {
              $errors[] = 'ISBN: ISBN must be numbers';
            }
            
            if (preg_match("/(\n|,)/",$lines[1])) {
              $errors[] = 'Publisher: publisher must be letters';
            }
          
            if (preg_match("/(\n|,)/",$lines[2])) {
              $errors[] = 'Name: name must be letters';
            }

            if (preg_match("/(\n|,)/",$lines[3])) {
              $errors[] = 'Author: author must be letters';
            }

            if (!preg_match("/^[0-9]+$/",$lines[4])) {
              $errors[] = 'Price: price must be numbers';
            }

            if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/",$lines[5])) {
              $errors[] = 'Release date: release date must be numbers';
            }
          
            // 錯誤訊息
            if(!empty($errors)){
              $message = implode("\n",$errors);
              echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
            }else{
              // 儲存資料
              $book = implode(',', $lines);
              $string[] = $book;
            }
          }
        }

      } // end reading
      
      // 開啟儲存位置
      $fhandle = fopen('./files/default.txt', 'a') or die ('系統錯誤');
      // 寫入default.txt
      if(empty($file_origin)){
        $record = implode("\n",$string);
      }else{
        $record = "\n". implode("\n",$string);
      }
      
      fwrite($fhandle, $record);
      fclose($fhandle);
      fclose($file_read);
      echo "<script type='text/javascript'>alert('上傳成功！');window.location.href='mainpage.php';</script>";
      
    }else{
      echo "<script type='text/javascript'>alert('不支援的檔案格式');history.go(-1);</script>";
    }
  }else{
    echo "<script type='text/javascript'>alert('檔案錯誤');history.go(-1);</script>";
  }
}
?>