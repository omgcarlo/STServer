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
      $time=date("h:i:sa");
      $cdatet = date("Y-m-d")." ".date("G:i", strtotime($time));
      $sql = "INSERT INTO comment(postId,userId,comment,datetime) Values($postId,'$userId','$comment','$cdatet')";
      return mysqli_query($this->conn,$sql);
    }
    public function selectAllComment($postId){
      //  GET ALL COMMENT FROM SINGLE POST
      $sql = "SELECT * from comment where postId = '$postId'";
      return mysqli_query($this->conn,$sql);
    }
    public function selectComment($commentId){
      $sql = "SELECT * FROM comment JOIN user ON user.schoolID = comment.userId WHERE commentId = $commentId ";
      return mysqli_query($this->conn,$sql);
    }
    public function approvedComment($commentId){
        $sql = "UPDATE comment SET isApproved = 1 where commentId = $commentId ";
        return mysqli_query($this->conn,$sql);
    }
    public function countComments($postId){
      $sql = "SELECT count(*) as ctr from comment where postId = $postId";
      $res = mysqli_query($this->conn,$sql);
      $row = mysqli_fetch_array($res);
      return $row['ctr'];

    }

}
?>
