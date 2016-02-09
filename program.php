<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
	$conn = mysqli_connect("localhost","root","chienihgwapo61296","socialtutor");

if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

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
$obj = new Program();
if(isset($_GET['action'])){
	$action = $_GET['action'];
	//die($action);
	if ($action == 'fetch') {
		$res =  mysqli_query($conn,$obj->getAllPrograms());
		if($res){
			$output = array();
			while($row = mysqli_fetch_array($res)){	
				$program = array();
	            //$program["Success"] = true;
	            //$program["Code"] = 200;
	            $program["Id"] = $row['programId'];
	            $program["Name"] = $row['name'];
	            $program["departmentId"] = $row['departmentId']; 
	            array_push($output,$program);  
            }
           echo json_encode(array('Program' => $output));
		}
		else{

		}
	}
}



?>
