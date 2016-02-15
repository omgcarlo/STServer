<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

include 'models/activity.php';

$obj = new Activity();

if(isset($_GET['action'])){
    $action = $_GET['action'];
    //  THIS PART IS FOR TESTIN PURPOSES
  /**  if($action == 'following'){
      /**
      *   ownerId refers to the user who does the action
      *   which leaves the fromId to whom it refers
      *   when one follows another user
      *   this function should be called
      */
    /*  $ownerId = $_POST['ownerId'];
      $desc = "followed";
      $fromId = $_POST['fromId'];
    }
    else if($action == 'comment'){
      /**
      *   the ownerId(YOU) commented to fromId = postId
      */
    /*  $ownerId = $_POST['ownerId'];
      $desc = "commented";
      $fromId = $_POST['fromId'];
    }

    $res = $obj->insertActivity($ownerId,$desc,$fromId);
    $output = array();
    if($res){
      $output['Success'] = true;
    }
    else{
      $output['Success'] = false;
    }
    echo json_encode(array("Activity" => $output),JSON_PRETTY_PRINT);
    */
    if($action == 'getActivities'){
      $ownerId = $_POST['ownerId'];
       $res = $obj->getActivities($ownerId);
      $output = array();
      include_once 'user.php';
      $user = new User();
      include_once 'post.php';
      $post = new Post();
      if($res){
          while($rowAct = mysqli_fetch_array($res)){
                $act = array();

                if($rowAct['act_description'] == 'followed'){
                  $rowUser = mysqli_fetch_array($user->getUserDetails($rowAct['ownerId']));
                  $act['Activity'] = "follow";
                  $desc = "followed you";
                }
                else{
                  //$rowPost = mysqli_fetch_array($post->getPost($rowAct['from_id']));
                  //die($user->getUserDetails($rowPost['ownerId']));
                  $rowUser = mysqli_fetch_array($user->getUserDetails($rowAct['ownerId']));
                  $act['Activity'] = "comment";
                  $desc = "commented on your post";
                  $act['postId'] = $rowAct['from_id'];
                }
                if($_POST['ownerId'] == $rowUser['schoolId']){
                  //  IF YOU COMMENT IN YOUR OWN POST
                  continue; //SKIP
                }
                $act['from_userId'] = $rowUser['schoolId'];
                $act['from_username'] = $rowUser['username'];
                $act['from_full_name'] = $rowUser['full_name'];
                if($rowUser['pic_url'] == 'default/pictures/ppic.jpg'){
                  $act['pic_url'] = 'http://'.$ip.
                                      '/STFinal/res/'.'default/pictures/ppic.jpg';
                }else{
                  $act['pic_url'] = 'http://'.$ip.
                                      '/STFinal/res/users/U_'.
                                      md5($rowUser['schoolId']).'/profile'. '/'.$rowUser['pic_url'];
                }
                $act['activityId'] = $rowAct['activityId'];
                $act['description'] = $desc;

                $act['datetime'] = $post->getTimePast($rowAct['date']);
                array_push($output,$act);
          }
          echo json_encode(array("Activity" => $output),JSON_PRETTY_PRINT);
      }
    }

}
?>
