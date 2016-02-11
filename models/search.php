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
        $sql = "Select * from post where tags like '%$params1%' OR description like '%$params1%' OR tags like '%$params2%' OR description like '%$params2%'";
        return mysqli_query($this->conn,$sql);
    }

 ?>
