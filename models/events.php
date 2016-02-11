<?php
include_once 'dbs.php';
$dbs = new dbs();
$conn = $dbs->connect();
/**
*   (c) INCC Group  2015-2016
*   EARLY TRAPPING!
*/
if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
class Event{
	  private $conn;
	public function __construct(){
        $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
	public function insertEvent($datedata,$title,$description,$ownerId){
		$sql = "INSERT into event(createdBy,event_title,description,event_date) VALUES('$ownerId','$title','$description','$datedata')";
		return mysqli_query($this->conn,$sql);
		//return $sql;
	}
	public function displayAllEvents(){
		$sql = "SELECT createdBy,fileId,event_title,description,event_date,username,full_name,pic_url from event join user on event.createdBy = user.schoolId";
		return mysqli_query($this->conn,$sql);
	}
  public function getEvent($edate){
    $sql = "Select * from event where event_date = '$edate'";
    return mysqli_query($this->conn,$sql);
  }
  public function getUpcomingEvents($edate,$udate){
    $sql = "SELECT * from event where event_date BETWEEN '$edate' AND '$udate' ORDER BY `event`.`event_date` ASC";
    return mysqli_query($this->conn,$sql);
  }
}
 ?>
