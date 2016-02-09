<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
	$conn = mysqli_connect("localhost","root","chienihgwapo61296","socialtutor");

	if (mysqli_connect_errno($conn))
	{
	   echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	class Note{
		public function __construct(){
		}
		public function selectNotesDetails($courseId,$schoolId){
			if($schoolId != null){
			$sql = "SELECT * FROM note JOIN course ON course.courseId = note.CourseId JOIN user ON user.schoolId = note.OwnerId WHERE note.CourseId = $courseId AND OwnerId = '$schoolId' ORDER BY CreatedDate";
			}
			else{
			$sql = "SELECT * FROM note JOIN course ON course.courseId = note.CourseId JOIN user ON user.schoolId = note.OwnerId WHERE note.CourseId = $courseId ORDER BY CreatedDate";	
			}
			return $sql;
		}
		public function insert($CourseId,$OwnerId,$Description,$FileName){
			$sql = "INSERT INTO note(CourseId,OwnerId,Description,FileName) VALUES($CourseId,'$OwnerId','$Description','$FileName')";
			return $sql;
		}
		public function getNoOfNotes($conn,$courseId,$schoolId){
			$result = mysqli_query($conn,$this->selectNotesDetails($courseId,$schoolId));
			return $result->num_rows;
		}
	}

?>