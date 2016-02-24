<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include_once 'dbs.php';


class Course{
	private $conn;
	public function __construct(){
		$dbs = new dbs();
		$this->conn = $dbs->connect();
	}
	public function insert($collegeCode,$courseNo,$title,$schoolId){
		$sql = "INSERT INTO course(CollegeCode,courseNo,descriptive_title,CreatedBy) VALUES('$collegeCode','$courseNo','$title','$schoolId')";
		return mysqli_query($this->conn,$sql);
	}
	public function selectCourses(){
		$sql = "Select * from course";
		return mysqli_query($this->conn,$sql);
	}
	public function selectCourse($programId){
		$sql = "SELECT * FROM course where courseId = $programId";
		return mysqli_query($this->conn,$sql);
	}
	public function selectCollegeCourses($collegeId){
		$sql = "SELECT * FROM course WHERE CollegeCode = '$collegeId' ORDER BY courseNo";
		return mysqli_query($this->conn,$sql);
	}
	public function programsDetails(){
		$sql = "SELECT * FROM program JOIN college ON college.CollegeCode = program.CollegeCode";
		return mysqli_query($this->conn,$sql);
	}
	public function programDetails($programId){
		$sql = "SELECT * FROM program JOIN college ON college.CollegeCode = program.CollegeCode WHERE programId = $programId";
		return mysqli_query($this->conn,$sql);
	}
	public function collegePrograms($collegeCode){
		$sql = "SELECT * FROM program WHERE CollegeCode = '$collegeCode'";
		return mysqli_query($this->conn,$sql);
	}
	public function getCourse($ccode){
		$sql = "SELECT * FROM course where CollegeCode = '$ccode'";
		return mysqli_query($this->conn,$sql);
	}
}
/*$course = new Course();
if(isset($_POST['college1']) && isset( $_POST['courseNo1']) && isset($_POST['title1'])){
	$collegeCode = $_POST['college1'];
	$courseNo = $_POST['courseNo1'];
	$title = $_POST['title1'];
	$schoolId = $_POST['schoolId1'];
	$res = mysqli_query($conn,$course->insert($collegeCode,$courseNo,$title,$schoolId));
	if($res){
		echo 'Success';
	}
	else{
		echo 'Wrong';
	}
} */



?>
