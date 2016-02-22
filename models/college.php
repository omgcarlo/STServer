<?php

include_once 'dbs.php';
/**
*   (c) INCC Group  2015-2016
*/
class College{
		private $conn;
		public function __construct(){
			$dbs = new dbs();
			$this->conn = $dbs->connect();
		}
		public function selectColleges(){
			$sql = "SELECT * FROM college";
			return mysqli_query($this->conn,$sql);
		}
		public function selectCollege($collegeCode){
			$sql = "SELECT * FROM college WHERE collegeCode = '$collegeCode'";
			return mysqli_query($this->conn,$sql);
		}
		public function getCollegePrograms($collegeCode){
			$sql = "SELECT * FROM program WHERE CollegeCode = '$collegeCode'";
			return mysqli_query($this->conn,$sql);
		}
		public function getCourse($college){
			$sql = "SELECT * FROM course WHERE CollegeCode = '$college' AND status = 'A'";
			return mysqli_query($this->conn,$sql);
		}
		public function getCollegeCodeFromCourse($courseId){
			$sql = "SELECT * FROM course WHERE courseId= '$courseId' AND status = 'A'";
			$row = mysqli_fetch_array(mysqli_query($this->conn,$sql));
			return $row;
		}

}
?>
