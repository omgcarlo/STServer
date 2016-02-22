<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');

include 'models/program.php';
$obj = new Program();

if(isset($_GET['action'])){
	$action = $_GET['action'];
	//die($action);
	if ($action == 'fetch') {
		$res =  $obj->getAllPrograms();
		if($res){
			$output = array();
			while($row = mysqli_fetch_array($res)){
				$program = array();
	            //$program["Success"] = true;
	            //$program["Code"] = 200;
	            $program["id"] = $row['ProgramId'];
	            $program["name"] = $row['ProgramName'];
	            $program["code"] = $row['CollegeCode'];
	            array_push($output,$program);
            }
           echo json_encode(array('Program' => $output),JSON_PRETTY_PRINT);
			}
		}

		else if($action == 'get'){
			$code = strtoupper($_GET['code']);
			$res =  $obj->getProgramFromCode($code);
				$output = array();
			if($res){

				while($row = mysqli_fetch_array($res)){
					$program = array();
								//$program["Success"] = true;
								//$program["Code"] = 200;
								$program["id"] = $row['ProgramId'];
								$program["name"] = $row['ProgramName'];
								$program["code"] = $row['CollegeCode'];
								array_push($output,$program);
					}
						 echo json_encode(array('Program' => $output),JSON_PRETTY_PRINT);
	  	}
		}
	}
?>
