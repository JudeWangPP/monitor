<?php
/*
 * 连接数据库基类，默认连接63
 */
require_once "config.php";
class SSH2Conn{
	
 	private $_conn=null;

 	public function getConn($host=SSH_HOST,$port=SSH_PORT,$username=SSH_USER,$password=SSH_PASS){
 		try{
 			$this->_conn=ssh2_connect($host,$port);
 			ssh2_auth_password($this->_conn,$username,$password);
 			return $this->_conn;
 		}catch(PDOException $e){
 			echo "SHHConn getConn() fail:".$e->getMessage();
 			$_conn=null;
 			return false;
 		}	
 	}
 	function __desctruct(){
 		$this->_conn=null;
 	}
 	
//  	$con=ssh2_connect('192.168.14.99',22);
//  	ssh2_auth_password($con,'tester','nopass.2');
//  	$stream = ssh2_exec($con, 'pwd');
//  	stream_set_blocking($stream, true);
//  	while($line = fgets($stream)) {
//  		flush();
//  		echo $line."<br />";
//  	}
 	
}
?>
