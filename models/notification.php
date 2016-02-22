<?php
include_once 'dbs.php';

/**
*   (c) INCC Group  2015-2016
*/

class Notification{
	private $conn;
	public function __construct(){
		 $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
  public function insertNotification($to_userId,$reference,$description,$referenceId,$fromId){
    //  From Id determines the person who initiated the notification
    //  referenceId  is from the post or comment
    $sql = "INSERT INTO `notification`(`to_userId`, `reference`, `description`,`status`, `referenceId`,`fromId`)
                                VALUES ('$to_userId','$reference','$description','N',$referenceId,'$fromId')";
    return mysqli_query($this->conn,$sql);
    //return $sql;
  }
  public function selectNotification($ownerId){
    //  N = NEW
    $sql = "Select * from notification where to_userId = '$ownerId' and status = 'N'";

    return mysqli_query($this->conn,$sql);
    //return $sql;
  }
  public function updateStatus($notificationId){
    //  R  = READ
    $sql = "UPDATE notification SET status = 'R' where notificationId = '$notificationId'";
    return mysqli_query($this->conn,$sql);
  }
}
 ?>
