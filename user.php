<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');

include 'models/user.php';
$obj = new User();
if(isset($_GET['action'])){
	$action = $_GET['action'];
	//die($action);
	if ($action == 'login') {

		$username = $_POST['username'];
		$password = $_POST['password'];
		//die($username.$password);
		$res =  mysqli_query($conn,$obj->login($username,$password));
		//$res = mysqli_query($conn,$obj->login('121-122','jacalan'));
		if($res){
			$row = mysqli_fetch_array($res);

			if($row['schoolId'] != null){
				//echo $row['schoolId'];
				$res1 = $obj->userDetails($row['schoolId']);
        //die($obj->userDetails($row['schoolId']));
				$row1 = mysqli_fetch_array($res1);
				$userc = array();
	            $userc["Success"] = true;
	            $userc["Name"] = $row1['full_name'];
	            $userc["Username"] = $row1['username'];
                $userc["Bio"] = $row1['bio'];
	            $userc["SchoolId"] = $row1['schoolId'];
	            $userc["Program"] = $row1['name'];
	            $userc["College"] = $row1['CollegeName'];

	            $output = json_encode(array('User' => $userc));

            }
            else{
            	$userc["Success"] = false;
	            $output = json_encode(array('User' => $userc));
            }
             echo $output;
		}
	}
	else if($action == 'signup'){
		//die("wew");
		$username = $_POST['username'];
		$password = $_POST['password'];
		$birthdate = $_POST['birthdate'];
		$email = $_POST['email'];
		$programId = $_POST['programId'];
		$full_name = $_POST['full_name'];
		$schoolId = $_POST['schoolId'];
		//echo $username . "," .$password. "," .$birthdate. "," .$email. "," .$birthdate;

		if(isset($_POST['pic_url'])){
			$pic_url = $_POST['pic_url'];
		}
		else{
			$pic_url = "default/pictures/ppic.jpg";	//default pic
		}
		//echo $obj->signup($schoolId,$username,$password,$birthdate,$email,1,$full_name,$pic_url);
		$res = mysqli_query($conn,$obj->signup($schoolId,$username,$password,$birthdate,$email,1,$full_name,$pic_url));
		$userc = array();
		if($res){
			$rootDir = "../res/users/".$schoolId;
			//	MAKE ROOT DIR
			mkdir($rootDir);
			//	PROFILE DIR
			mkdir($rootDir."/profile");
			//	FOR FILES FOLDER
			mkdir($rootDir."/files");
			//================= UPLOAD IMAGE ============

			$userc["Success"] = true;
		}
		else{
			$userc["Success"] = false;
		}
		echo json_encode(array('User' => $userc));
	}
	else if($action == 'addfollowing'){
		$imongId = $_POST['imo'];
		$iyangId = $_POST['iya'];
		$rowUser = mysqli_fetch_array($obj->getUserDetails($imongId));
		$ids = explode(",",$rowUser['following_ids']);
        for($i = 0 ; $i < count($ids);$i++ ){
        //CHECK iF NA FOLLOW NA SIYA
        	if($iyangId == $ids[$i]){
        		$output = array();
        		$output['Success'] = false;
        		die(json_encode(array('Follow' => $output)));
        	}
        }
		$res = $obj->addFollowing($imongId,$iyangId);
		$output = array();
		if($res){
			$output['Success'] = true;
      //  ADD ACTIVITY
      include_once 'models/activity.php';
      $act = new Activity();
      $desc = "followed";
      $act->insertActivity($imongId,$desc,$iyangId);
			//  ADD NOTIFICATION
			include_once 'models/notification.php';
			$notif = new Notification();
			$notif->insertNotification($iyangId,"follow","followed","",$imongId);
		}
		else{
			$output['Success'] = false;
		}
		echo json_encode(array('Follow' => $output));
	}
  else if($action == "unfollow"){
    $imongId = $_POST['imo'];
    $iyangId = $_POST['iya'];
    $res = $obj->unfollow($imongId,$iyangId);
    $output = array();
    if($res){
      $output['Success'] = true;
    }
    else{
      $output['Success'] = false;
    }
      echo json_encode(array('Follow' => $output));
  }
  else if($action == "getUserCredentials"){

      $imongId = $_POST['imo'];
      if(isset($_POST['iya'])){
        $iyangId = $_POST['iya'];
        $res = $obj->getUserDetails($iyangId);
      }
      else{
        $res = $obj->getUserDetails($imongId);
      }
      $rowUser = mysqli_fetch_array($res);
      $userd = array();
      $userd['full_name'] = $rowUser['full_name'];
      $userd['username'] = $rowUser['username'];
      $userd['bio'] = $rowUser['bio'];
      $followers = count(explode(",",$rowUser['followers']))-1;
      $followings = count(explode(",",$rowUser['following_ids']))-1;
      $userd['followers'] = $followers;
      $userd['followings'] = $followings;
      include_once 'post.php';
      $post = new Post();
      $rowPost = mysqli_fetch_array($post->getCountPost($userId));
      $userd['posts'] = $rowPost['cpost'];
      if($iyangId != null){
        $userd['isFollowed'] =  $obj->isFollowed($imongId,$iyangId);
      }


      echo json_encode(array("User" => $userId),JSON_PRETTY_PRINT);
  }
}



?>
