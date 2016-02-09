<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

include_once 'dbs.php';
$dbs = new dbs();

$conn = $dbs->connect();


if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

class Activity{
	private $conn;
	public function __construct(){
		 $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
	public function insertActivity($ownerId,$desc,$from_id){
		/**
		*	fromId asa girefer ang imong gipangbuhat
		*	ang ownerId kay imo ng ID
		*	fromId maybe user or comment or unswaba
		*/
    $cdatet = date("Y-m-d")." ".date("h:i:s");
		$sql = "INSERT into activity(ownerId,act_description,from_id,`date`) values('$ownerId','$desc','$from_id','$cdatet')";
		return mysqli_query($this->conn,$sql);
	}
	public function getActivities($ownerId){
		$sql = "SELECT * from activity where from_id = '$ownerId' or from_id =
                (SELECT postId from user JOIN (SELECT post.postId,post.ownerId from activity JOIN
                  post as post ON activity.from_id = post.postId GROUP BY post.postId ) as posti ON
                   user.schoolId = posti.ownerId where posti.ownerId = '$ownerId') ORDER BY `activity`.`date` DESC";
		return mysqli_query($this->conn,$sql);
	}

}

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