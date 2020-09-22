<?php

class Database{
	public $host = "localhost";
	public $user = "root";
	public $pass = "";
	public $name = "pdo";

	public $conn;
	public $error;

	function __construct(){
		$this->connetion();
	}

	function connetion(){
		$this->conn = new mysqli($this->host,$this->user,$this->pass,$this->name);
		if (!$this->conn) {
			$this->error = "Connection failed...".$this->conn->connect_error;
		}
	}

	// Insert Query
	function insert($sql){
		$data = $this->conn->query($sql) or die($this->conn->error.__LINE__);
		if($data){
			return $data;
		} else{
			return false;
		}
	}

	// Select Query
	function select($sql){
		$data = $this->conn->query($sql) or die($this->conn->error.__LINE__);
		if($data->num_rows > 0){
			return $data;
		} else{
			return false;
		}
	}

	function delete($sql){
		$data = $this->conn->query($sql) or die($this->conn->error.__LINE__);
		if ($data) {
			return $data;
		} else{
			return false;
		}
	}
}

?>