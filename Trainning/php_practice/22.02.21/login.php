<?php
include('class/DBconnect.php');

session_start();
if(isset($_SESSION['user'])){
    header("Location: home.php");
    exit;
}

if(isset($_POST['login'])){

    if(empty($_POST['username']) || empty($_POST['password'])){
        echo "<script type='text/javascript'>alert('Please enter value');history.go(-1);</script>";
		exit;
    }elseif(!preg_match("/^[a-zA-Z0-9]{4,12}$/", $_POST['username'])){
        echo "<script type='text/javascript'>alert('User name is only allowed to use letters and numbers');history.go(-1);</script>";
		exit;
    }elseif(!preg_match("/^[a-zA-Z0-9]{4,12}$/", $_POST['password'])){
        echo "<script type='text/javascript'>alert('Password is only allowed to use letters and numbers');history.go(-1);</script>";
		exit;
    }else{
        $username = mysql_real_escape_string(strval($_POST['username']));
        $password = mysql_real_escape_string(strval($_POST['password']));
        $sql = "SELECT * FROM `users` WHERE `username`='$username' LIMIT 1";
        $result = $DB->query($sql);
        $userdata = $DB->fetch($result);
        if($userdata['password'] === $password){
            $_SESSION['user'] = $userdata['username'];
            header("Location: home.php");
        }else{
            echo "<script type='text/javascript'>alert('Wrong password');history.go(-1);</script>";
		    exit;
        }
        $DB->close_con();
    }

}

include('xhtml/login.html');