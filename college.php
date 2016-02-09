<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
	$conn = mysqli_connect("localhost","root","chienihgwapo61296","socialtutor");

	if (mysqli_connect_errno($conn))
	{
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	class College{
		public function __construct(){
		}
		public function selectColleges(){
			$sql = "SELECT * FROM college";;
			return $sql;
		}
		public function selectCollege($collegeCode){
			$sql = "SELECT * FROM college WHERE collegeCode = '$collegeCode'";
			return $sql;
		}
		public function getCollegePrograms($collegeCode){
			$sql = "SELECT * FROM program WHERE CollegeCode = '$collegeCode'";
			return $sql;
		}
	}
?>