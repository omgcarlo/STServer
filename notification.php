<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

include_once 'dbs.php';
$dbs = new dbs();

$conn = $dbs->connect();


if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

class Notification{
	private $conn;
	public function __construct(){
		 $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
}

$obj = new Activity();
//  THIS PART IS FOR TESTIN PURPOSES


?>
