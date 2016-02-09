<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
	$conn = mysqli_connect("localhost","root","chienihgwapo61296","socialtutor");

if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

class Course{
	public function __construct(){
	}
	public function insert($collegeCode,$courseNo,$title,$schoolId){
		$sql = "INSERT INTO course(CollegeCode,courseNo,descriptive_title,CreatedBy) VALUES('$collegeCode','$courseNo','$title','$schoolId')";
		return $sql;
	}
	public function selectCourses(){
		$sql = "Select * from course";
		return $sql;
	}
	public function selectCourse($programId){
		$sql = "SELECT * FROM course where courseId = $programId";
		return $sql;
	}
	public function selectCollegeCourses($collegeId){

		$sql = "SELECT * FROM course WHERE CollegeCode = '$collegeId' ORDER BY courseNo";
		
		return $sql;
	}
	public function programsDetails(){
		$sql = "SELECT * FROM program JOIN college ON college.CollegeCode = program.CollegeCode";
		return $sql;
	}
	public function programDetails($programId){
		$sql = "SELECT * FROM program JOIN college ON college.CollegeCode = program.CollegeCode WHERE programId = $programId";
		return $sql;
	}
	public function collegePrograms($collegeCode){
		$sql = "SELECT * FROM program WHERE CollegeCode = '$collegeCode'";
		return $sql;
	}
}
$course = new Course();
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
}



?>
