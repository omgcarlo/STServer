<?php
include_once 'dbs.php';
$dbs = new dbs();


/**
*   (c) INCC Group  2015-2016
*/


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
    $time=date("h:i:sa");
    $cdatet = date("Y-m-d")." ".date("G:i", strtotime($time));
		$sql = "INSERT into activity(ownerId,act_description,from_id,`date`) values('$ownerId','$desc','$from_id','$cdatet')";
		return mysqli_query($this->conn,$sql);
	}
	public function getActivities($ownerId){
		$sql = "SELECT postId from user JOIN (SELECT post.postId,post.ownerId from activity JOIN post as post ON
		 activity.from_id = post.postId where post.ownerId = '$ownerId' GROUP BY post.postId ) as posti ON
		 user.schoolId = posti.ownerId where posti.ownerId = '$ownerId'";
		 $res = mysqli_query($this->conn,$sql);
		 $fromIds = "";
		 while($row = mysqli_fetch_array($res)){
		 	$fromIds .= " or from_id = ".$row['postId'];
		 }
		 //	ADD FROM
		 $sql = "SELECT * FROM `mentions` where to_userId = '$ownerId'";
		 $res = mysqli_query($this->conn,$sql);
		 while($row = mysqli_fetch_array($res)){
			 if($row['referenceTable'] == 'post')
		 		$fromIds .= " or from_id = ".$row['referenceId'];
		 }
		$sql = "SELECT * from activity where from_id = '$ownerId'". $fromIds ." ORDER BY `activity`.`date` DESC";
		return mysqli_query($this->conn,$sql);
		//die($sql);
	}

}
 ?>
