<?php
session_start();
/**
* 
*/
class Database
{
	Protected $db;
	function __construct()
	{
		try{
			$options = array(PDO::ATTR_EMULATE_PREPARES => false,  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			$this->db = new PDO('mysql:localhost;dbname=2577350_gnani','root','',$options);
			
			//echo "Connection Successfully";
		}catch(PDOException $e){
			echo "Connection Failed".$e->message();
		}
	}
	public function getLastInsertId()
	{
		return $this->db->lastInsertId();
	}

}


if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])  ) {
 	$http_referer = $_SERVER['HTTP_REFERER'];
 }else{
 	$http_referer = 'index.php';
 }


class data extends Database
{	
	function __construct()
	{
		parent::__construct();
	}

	Public function result($q, array $param_array = [])
	{	
		//echo $q;
		//print_r($param_array);
		$stmt = $this->db->prepare($q);
		$stmt->execute($param_array);
		if ($stmt->rowCount() >= 1 ) {
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			return NULL;
		}
		
	}
}

 ?>