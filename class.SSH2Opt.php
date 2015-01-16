<?php
require_once "class.SSH2Conn.php";
class SSH2Opt extends SSH2Conn{
	/**
	 * ssh2执行命令
	 */
	public function ssh2Exec($host,$command){
 		$conn=parent::getConn($host);
 		$result = array();
 		try{
			$stream = ssh2_exec($conn, $command);
	 		stream_set_blocking($stream, true);
			while($line = fgets($stream)) {
				flush();
// 				echo $line."<br />";
// 				echo gettype($line);
				array_push($result, $line);
			}
 			return $result;
 		}catch(PDOException $e){
 			echo "insertChannel() failed:".$e->getMessage();
 			return false;
 		}	
	}
	/**
	 * 更新一个渠道
	 */
	public function updateOneChannelNumber($id,$data){
		$conn=parent::getConn();

 		$sql="UPDATE channel_number Set channel_name=:channel_name,bd=:bd, " .
 			" has_sdk=:has_sdk,description=:description ".
 			" where id=:id ";
 		try{
 			$st=$conn->prepare($sql);
 			$st->bindValue(":id",$id,PDO::PARAM_INT);
 			$st->bindValue(":channel_name",$data["channel_name"],PDO::PARAM_STR);
 			$st->bindValue(":bd",$data["bd"],PDO::PARAM_STR);
 			$st->bindValue(":has_sdk",$data["has_sdk"],PDO::PARAM_STR);
 			$st->bindValue(":description",$data["description"],PDO::PARAM_STR);
 			$st->execute();
 			return true;
 		}catch(PDOException $e){
 			echo "updateOneChannelNumber():".$e->getMessage();
 			return false;
 		}			
	}
}
// 	$opt = new SSH2Opt();
// 	$val = $opt->ssh2Exec('192.168.14.99','ls /');
// 	print_r($val);
?>
