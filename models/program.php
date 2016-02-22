<?php
include_once 'dbs.php';
class Program{
	private $conn;
	public function __construct(){
				$dbs = new dbs();
				$this->conn = $dbs->connect();
	}
	public function getAllPrograms(){
		$sql = "Select * from program";
		return mysqli_query($this->conn,$sql);
	}
	public function selectProgram($programId){
		$sql = "SELECT * FROM program where ProgramId = $programId";
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
	public function getProgramFromCode($code){
		$sql = "SELECT * FROM program where CollegeCode= '$code'";
		return mysqli_query($this->conn,$sql);
	}
}
?>
