<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');

include 'models/college.php';
$obj = new College();
if(isset($_GET['action'])){
  $action = $_GET['action'];
  $output2 = array();
  if($action == "fetch"){
    $res = $obj->selectColleges();
      while($rowCollege = mysqli_fetch_array($res)){
          $output = array();
          $output['code'] = $rowCollege['CollegeCode'];
          $output['name'] = $rowCollege['CollegeName'];
          $output['dean'] = $rowCollege['dean'];
          array_push($output2,$output);
      }
      echo json_encode(array("College" => $output2),JSON_PRETTY_PRINT);
  }
  else if($action == 'getCourse'){
    $college = $_GET['college'];
    $res = $obj->getCourse($college);
      while($rowCollege = mysqli_fetch_array($res)){
          $output = array();
          $output['courseId'] = $rowCollege['courseId'];
          $output['courseNo'] = $rowCollege['courseNo'];
          $output['name'] = $rowCollege['descriptive_title'];
          $output['code'] = $rowCollege['CollegeCode'];
          array_push($output2,$output);
      }
      echo json_encode(array("Course" => $output2),JSON_PRETTY_PRINT);
  }

}
?>
