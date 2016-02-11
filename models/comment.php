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

class Comment{
    private $conn;
  	public function __construct(){
          $dbs = new dbs();
          $this->conn = $dbs->connect();
  	}
    public function insertComment($postId,$userId,$comment){
      $sql = "INSERT INTO comment(postId,userId,comment) Values($postId,'$userId','$comment')";
      return mysqli_query($this->conn,$sql);
    }
    public function selectAllComment($postId){
      //  GET ALL COMMENT FROM SINGLE POST
      $sql = "SELECT * from comment where postId = '$postId'";
      return mysqli_query($this->conn,$sql);
    }
    public function approvedComment($commentId){
        $sql = "UPDATE comment SET isApproved = 1 where commentId = $commentId ";
        return mysqli_query($this->conn,$sql);
    }

}
?>
