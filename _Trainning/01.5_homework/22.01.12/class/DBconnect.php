<?php

class DBconnect{

	private $host = 'localhost';
	private $dbuser ='root';
	private $dbpassword = '';
	private $dbname = 'form_test';

	public $link;
	public $result;
	

	function __construct(){
		$this->link = mysqli_connect($this->host,$this->dbuser,$this->dbpassword,$this->dbname);
		if($this->link){
			$this->query('SET NAMES utf8');
		}
	}

	function query($sql){
		$this->result = mysqli_query($this->link, $sql);
		return $this->result;
	}

	function countrow(){
		$result_check = mysqli_num_rows($this->result);
		return $result_check;
	}

	function fetch(){
		$line = mysqli_fetch_assoc($this->result);
		return $line;
	}
	
	function affected(){
		$quantity = mysqli_affected_rows($this->link);
		return $quantity;
	}

	function close_con(){
		$close = mysqli_close($this->link);
	}

}

$DB = new DBconnect();


?>