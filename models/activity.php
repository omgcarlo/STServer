<?php
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
    $cdatet = date("Y-m-d")." ".date("h:i:s");
		$sql = "INSERT into activity(ownerId,act_description,from_id,`date`) values('$ownerId','$desc','$from_id','$cdatet')";
		return mysqli_query($this->conn,$sql);
	}
	public function getActivities($ownerId){
		$sql = "SELECT * from activity where from_id = '$ownerId' or from_id =
                (SELECT postId from user JOIN (SELECT post.postId,post.ownerId from activity JOIN
                  post as post ON activity.from_id = post.postId GROUP BY post.postId ) as posti ON
                   user.schoolId = posti.ownerId where posti.ownerId = '$ownerId') ORDER BY `activity`.`date` DESC";
		return mysqli_query($this->conn,$sql);
	}

}
 ?>
