<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
include 'models/program.php';
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
