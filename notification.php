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

class Activity{
	private $conn;
	public function __construct(){
		 $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
	public function insertActivity($ownerId,$desc,$from_id){
		/**
		*	fromId asa girefer ang imong gipangbuhat
		*	ang ownerId kay imo ng ID
		*	fromId maybe user or comment or unswaba
		*/
		$sql = "INSERT into activity(ownerId,act_description,from_id) values('$ownerId','$desc','$from_id')";
		return mysqli_query($this->conn,$sql);
	}
	public function getActivities($ownerId){
		$sql = "Select * from activity where ownerId = '$ownerId' ASC";
		return mysqli_query($this->conn,$sql);
	}
  public function getUserActivities(){
    $sql = "SELECT * from activity JOIN user ON user.userId = activity.ownerId ";
  }
}

$obj = new Activity();
//  THIS PART IS FOR TESTIN PURPOSES


?>
