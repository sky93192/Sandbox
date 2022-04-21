<?php

class Model{
    private $server = "localhost";
    private $username = "root";
    private $password;
    private $db = "oop_crud";
    private $conn;

    public function __construct(){
        try{
            $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db);
        }catch(Exception $e){
            echo "Connection failed ". $e->getMessage();
        }
    }

    public function insert(){
        if(isset($_POST['submit'])){
            if(empty($_POST["name"])){
                $errors[] = 'Please enter name';
            }else{
                $name = strval($_POST["name"]);
            }

            if(empty($_POST["email"])){
                $errors[] = 'Please enter email';
            }else{
                $email = strval($_POST["email"]);
            }

            if(empty($_POST["mobile"])){
                $errors[] = 'Please enter mobile';
            }else{
                $mobile = strval($_POST["mobile"]);
            }

            if(empty($_POST["address"])){
                $errors[] = 'Please enter address';
            }else{
                $address = strval($_POST["address"]);
            }

            if(isset($errors)){
                $message = implode("\n",$errors);
                echo "<script type='text/javascript'>alert('$message');history.go(-1);</script>";
                exit();
            }else{
                $query = "INSERT INTO `records` (name,email,mobile,address) VALUES ('$name','$email','$mobile','$address')";
                $sql = $this->conn->query($query);
                echo "<script type='text/javascript'>alert('Added successfully!');window.location.href='index.php';</script>";
                exit();
            }


        }
    }

    public function fetch(){
        $data = array();
        $query = "SELECT * FROM `records`";
        if($sql = $this->conn->query($query)){
            while($row = mysqli_fetch_assoc($sql)){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function delete($id){
        $query = "DELETE FROM `records` WHERE `id`='$id'";
        $sql = $this->conn->query($query);
    }

    public function fetch_single($id){
        $data = null;
        $query = "SELECT * FROM `records` WHERE `id`='$id'";
        $sql = $this->conn->query($query);
        while($row = $sql->fetch_assoc()){
            $data = $row;
        }
        return $data;
    }

    public function edit($id){
        $data = null;
        $query = "SELECT * FROM `records` WHERE `id`='$id'";
        $sql = $this->conn->query($query);
        while($row = $sql->fetch_assoc()){
            $data = $row;
        }
        return $data;
    }

    public function update($data){
        $query = "UPDATE `records` SET `name`=\'data['name']\', `email`=\'data['email']\', `mobile`=\'data['mobile']\', 
        `address`=\'data['address']\' WHERE `id`=\'data['id']\'";
        $sql = $this->conn->query($query);
    }
}