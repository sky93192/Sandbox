<?php
include('class/DBconnect.php');

session_start();
if(isset($_SESSION['user'])){
    header("Location: home.php");
    exit;
}

if(isset($_POST['signup'])){

    if(empty($_POST['username']) || empty($_POST['password']) || empty($_POST['password_confirm'])){
        echo "<script type='text/javascript'>alert('Please enter value');history.go(-1);</script>";
		exit;
    }elseif(!preg_match("/^[a-zA-Z0-9]{4,12}$/", $_POST['username'])){
        echo "<script type='text/javascript'>alert('User name has to be 4 to 12 letters long and only allowed to use letters and numbers');history.go(-1);</script>";
		exit;
    }elseif(!preg_match("/^[a-zA-Z0-9]{4,12}$/", $_POST['password'])){
        echo "<script type='text/javascript'>alert('Password has to be 4 to 12 letters long and only allowed to use letters and numbers');history.go(-1);</script>";
		exit;
    }elseif($_POST['password_confirm'] !== $_POST['password']){
        echo "<script type='text/javascript'>alert('Please check password again');history.go(-1);</script>";
        exit;
    }else{
        $username = mysql_real_escape_string(strval($_POST['username']));
        $password = mysql_real_escape_string(strval($_POST['password']));
        $sql = "SELECT * FROM `users` WHERE `username`='$username' LIMIT 1";
        $result = $DB->query($sql);
        if($DB->countrow($result) >= 1){
            echo "<script type='text/javascript'>alert('This user name has exist');history.go(-1);</script>";
            $DB->close_con();
            exit;
        }else{
            $sql = "INSERT INTO `users` (`username`, `password`) VALUES ('$username', '$password')";
            $DB->query($sql);
            $DB->close_con();

            header("Location: login.php");
        }
        
    }

}

include('xhtml/signup.html');