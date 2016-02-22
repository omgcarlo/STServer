<?php
include_once 'dbs.php';
$dbs = new dbs();
$conn = $dbs->connect();
/**
*   (c) INCC Group 2015-2016
*   EARLY TRAPPING!
*/
if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

class Search{
    private $conn;
	public function __construct(){
       $dbs = new dbs();
       $this->conn = $dbs->connect();
	}
	public function searchPerson($params,$imongId){
        $sql = "Select * from user where (schoolId <> '$imongId' AND username like '%$params%') OR (schoolId <> '$imongId' AND full_name like '%$params%')";
        return mysqli_query($this->conn,$sql);
    }
    public function searchTopics($params1,$params2){
        $sql = "Select * from post JOIN comment ON post.postId = comment.postId
         where tags like '%$params1%' OR description like '%$params1%' OR
         tags like '%$params2%' OR description like '%$params2%' OR
         comment like '%$params1%' OR comment like '%$params2%'";
        return mysqli_query($this->conn,$sql);
    }
    public function discoverTopics($params1,$code){
      $fileIds = "";
      $sql = "SELECT fileId from note where CourseId = (SELECT courseId from course where courseNo = '$code')";
      $res = mysqli_query($this->conn,$sql);
      while($row = mysqli_fetch_array($res)){
           $fileIds .= " OR fileId = ".$row['fileId'];
         }
      if($params = ""){
        $sql = "SELECT * from post where tags like '%$params1%' OR description like '%$params1%' OR
        tags like '%$code%' OR description like '%$code%'";
      }
      else{
        $sql = "SELECT * from post Join user On post.ownerId = user.schoolId where post.status = 'A' AND
        tags like '%$code%' OR post.status = 'A' AND description like '%$code%'";
      }

      //die($sql.$fileIds);
      return mysqli_query($this->conn,$sql);
    }
    public function discoverNotes($searchQ,$ccode){
    /*  $sql = "SELECT * from post JOIN file ON post.fileId = file.fileId where
              post.description like '%$searchQ%' OR post.tags like '%$searchQ%' OR post.tags like '%$ccode%'
              file.description like '%$searchQ%'";
              */
      $sql = "SELECT * from note JOIN file ON note.fileId = file.fileId where
                file.description like '%$searchQ%' and note.courseId = (SELECT courseId from course where courseNo = '$ccode') OR note.Description like '%$searchQ%'
                 and note.courseId = (SELECT courseId from course where courseNo = '$ccode')";

       return mysqli_query($this->conn,$sql);
    }
    public function searchQuestions($params){
      $sql = "SELECT * from post JOIN comment ON post.postId = comment.postId where comment.isApproved = 0";
      return mysqli_query($this->conn,$sql);
    }
}
 ?>
