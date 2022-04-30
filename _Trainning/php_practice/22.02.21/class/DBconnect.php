<?php

class DBconnect{

	private $host = ':/tmp/mysql.sock';
	private $dbuser ='root';
	private $dbpassword = 'l7fwmysql';
	private $dbname = 'code_review';

	public $link;
	public $db;
	public $result;
	

	function __construct(){
		$this->link = mysql_connect($this->host,$this->dbuser,$this->dbpassword);
		$this->db = mysql_select_db('code_review', $this->link);
		if($this->link){
			$this->query('SET NAMES utf8');
		}
	}

	function query($sql){
		$this->result = mysql_query($sql, $this->link);
		return $this->result;
	}

	function countrow(){
		$result_check = mysql_num_rows($this->result);
		return $result_check;
	}

	function fetch(){
		$line = mysql_fetch_assoc($this->result);
		return $line;
	}
	
	function affected(){
		$quantity = mysql_affected_rows($this->link);
		return $quantity;
	}

	function close_con(){
		$close = mysql_close($this->link);
	}

}

$DB = new DBconnect();


?>