<?php
$host= gethostname();
$ip = gethostbyname($host);
/**
*   (c) INCC Group  2015-2016
*		coded by Carlo Jacalan
*		for socialngatutor mobile app
*		contact: carlojacalan1@gmail.com
*/
class dbs{
		public function __construct(){}
		public function connect()
		{
			//$username = "a1414431_admin1";
			//$pass = "adminpassword";
			//$table = "a1414431_sntd";
			//$conn = mysqli_connect("localhost",$username,$pass,$pass);
			$conn = mysqli_connect("localhost","root","","stdbv2");
			if(!$conn)
				die("Can't connect to server!");
			return $conn;
		}
		public function execute($sql)
		{
			return mysqli_query($this->connect(),$sql);
		}
		public function fetch($res){
			return mysqli_fetch_array($res);

		}
}
?>
