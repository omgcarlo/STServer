<?php
class Program{
	public function __construct(){
	}
	public function getAllPrograms(){
		$sql = "Select * from program";
		return $sql;
	}
	public function selectProgram($programId){
		$sql = "SELECT * FROM program where ProgramID = $programId";
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
?>
