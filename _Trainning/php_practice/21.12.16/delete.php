<?php
require_once "DBconnect.php";

if(isset($_GET['id'])){
    $id = $link->real_escape_string($_GET['id']);
    $check_sql = "SELECT * FROM contact_list WHERE `id`=$id";
    $check = mysqli_query($link,$check_sql);

    if(isset($check)){
        $sql = "DELETE FROM contact_list WHERE `id`=$id";
        $result = mysqli_query($link,$sql);
    }else{
        header('Location: ./view/contact_list.php');
    }

    if (mysqli_affected_rows($link)>0) {
        header('Location: ./view/contact_list.php');
        } // else {
        //     echo "{$sql} Delete fail! " . mysqli_error($link);
        // }
        mysqli_close($link); 
}