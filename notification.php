<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');
ini_set('memory_limit', '128M');
include_once 'models/notification.php';

$obj = new Notification();
if(isset($_GET['action'])){
  $action = $_GET['action'];
  if($action == 'get'){
      $ownerId = $_POST['ownerId'];
      $res = $obj->selectNotification($ownerId);
      if($res){
        $rowNotification = mysqli_fetch_array($res);
        $output = array();
        $output['Notification'] = $rowNotification['reference'];
        $output['notificationId'] = $rowNotification['notificationId'];
        $output['description'] = $rowNotification['description'];
        $output['referenceId'] = $rowNotification['referenceId'];
        if($rowNotification['fromId'] != NULL){
          include_once 'user.php';
          $user = new User();

          $rowUser = mysqli_fetch_array($user->getUserDetails($rowNotification['fromId']));
          $output['from_username'] = $rowUser['username'];
          $output['from_userId'] =  $rowUser['schoolId'];
        }
        echo json_encode(array("Notification" => $output),JSON_PRETTY_PRINT);
    }
  }
  elseif ($action == 'update') {
    $res = $obj->updateStatus($_POST['notificationId']);
    $output = array();
    if($res){
      $output['Success'] = true;
    }
    else{
      $output['Success'] = false;
    }
  }
}

?>
