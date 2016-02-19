<?php
include_once 'dbs.php';
$dbs = new dbs();
$conn = $dbs->connect();
    /**
    *   (c) INCC Group  2015-2016
    */
class Report{
    private $conn;
  	public function __construct(){
          $dbs = new dbs();
          $this->conn = $dbs->connect();
  	}
     public function insertReport($ownerId, $referenceTable, $referenceId){
     $time=date("h:i:sa");
     $cdatet = date("Y-m-d")." ".date("G:i", strtotime($time));
      $sql = "INSERT INTO `report`(`ownerId`, `referenceTable`, `referenceId`, `reportDate`, `status`)
              VALUES ('$ownerId', '$referenceTable', $referenceId, '$cdatet','P')";
       return mysqli_query($this->conn,$sql);
    }
    public function selectAllReport(){
      //  GET ALL COMMENT FROM SINGLE POST
      $sql = "SELECT * from report";
      return mysqli_query($this->conn,$sql);
    }
    public function selectReportsDetails(){
      $sql = "SELECT reportId,full_name,referenceId,referenceTable,reportDate,report.status AS 'status' FROM report JOIN user ON user.schoolId = report.ownerId ";
      return mysqli_query($this->conn,$sql);
    }

    // public function approvedComment($commentId){
    //     $sql = "UPDATE comment SET isApproved = 1 where commentId = $commentId ";
    //     return mysqli_query($this->conn,$sql);
    // }

}
?>
