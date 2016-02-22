<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');

include 'models/user.php';
$obj = new User();
if(isset($_GET['action'])){
	$action = $_GET['action'];
	//die($action);
	if ($action == 'login') {

		$username = $_POST['username'];
		$password = $_POST['password'];
		//die($username.$password);
		$res =  $obj->login($username,$password);
		//$res = mysqli_query($conn,$obj->login('121-122','jacalan'));
		if($res){

			$ip = gethostbyname(gethostname());
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
							$userc['pic_url'] = 'http://'.$ip.
							 										'/STFinal/res/users/U_'.
																	md5($row1['schoolId']).'/profile'. '/'.$row1['pic_url'];
            }
            else{
            	$userc["Success"] = false;

            }
             echo json_encode(array('User' => $userc),JSON_PRETTY_PRINT);;
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

		$res = mysqli_query($conn,$obj->signup($schoolId,$username,$password,$birthdate,$email,1,$full_name,$pic_url));
		$userc = array();
		if($res){
			$rootDir = "../res/users/"."U_". md5($schoolId);
			//	MAKE ROOT DIR
			mkdir($rootDir);
			//	PROFILE DIR
			$profileDir = $rootDir."/profile";
			mkdir($profileDir);

			//	FOR FILES FOLDER
			$fileDir = $rootDir."/files";
			mkdir($fileDir);

			//================= UPLOAD IMAGE ============
			$target_path1 = $profileDir . "/";
			$countFiles = new FilesystemIterator($target_path1, FilesystemIterator::SKIP_DOTS);
			//echo iterator_count($countFiles);
			// 	rename the file
			$new_name = "P_". md5(iterator_count($countFiles)) . ".jpg" ;
			$target_path1 = $target_path1 . $new_name;

			if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path1)) {
						$res = $obj->updatePicUrl($new_name,$schoolId);	//	UPDATE PIC URL
						if ($res) {
							  $userc["UploadSuccess"] = true;
						} else{
						    $userc["UploadSuccess"] = false;
						}
			}
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
	// FOR PROFILE
  else if($action == "getUserCredentials"){

      $imongId = $_POST['imo'];
			$iyangId = null;
			$whatId;
      if(isset($_POST['iya']) && $_POST['iya'] != null){
        $iyangId = $_POST['iya'];
        $res = $obj->getUserDetails($iyangId);
				$whatId = $iyangId;
      }
      else{
				$whatId = $imongId;
        $res = $obj->getUserDetails($imongId);
      }
			if($res){
		      $rowUser = mysqli_fetch_array($res);
		      $userd = array();
		      $userd['full_name'] = $rowUser['full_name'];
		      $userd['username'] = $rowUser['username'];
		      $userd['bio'] = $rowUser['bio'];
					if($rowUser['pic_url'] == 'default/pictures/ppic.jpg'){
						$userd['pic_url'] = 'http://'.$ip.
																'/STFinal/res/'.'default/pictures/ppic.jpg';
					}else{
						$userd['pic_url'] = 'http://'.$ip.
																'/STFinal/res/users/U_'.
																md5($rowUser['schoolId']).'/profile'. '/'.$rowUser['pic_url'];
					}
		      $followers = count(explode(",",$rowUser['followers']))-1;
		      $followings = count(explode(",",$rowUser['following_ids']))-1;
		      $userd['followers'] = $followers;
		      $userd['followings'] = $followings;

		      include_once 'post.php';
		      $post = new Post();
					$obj = new User();
		      $rowPost = mysqli_fetch_array($post->getCountPost($whatId));;
		      $userd['posts'] = $rowPost['cpost'];
					$userd['userType'] = $rowUser['UserType'];
		      if($iyangId != null){
		        $userd['isFollowed'] =  $obj->isFollowed($imongId,$iyangId);
		      }
					else{
						$userd['isFollowed'] = null;
					}
		      echo json_encode(array("User" => $userd),JSON_PRETTY_PRINT);
		}
  }

	else if($action == 'getFollowingPeople'){
			$userId = $_POST['userId'];
			$rowOwner = mysqli_fetch_array($obj->getUserDetails($userId));
			$userIds = explode(",",$rowOwner['following_ids']);
			$output = array();
			for($i = 0 ; $i < count($userIds) - 1; $i++){
					$userc = array();
					$rowUser = mysqli_fetch_array($obj->getUserDetails($userIds[$i]));
					$userc['schoolId'] = $rowUser['schoolId'];
					$userc['username'] = $rowUser['username'];
					$userc['full_name'] = $rowUser['full_name'];
					if($rowUser['pic_url'] == 'default/pictures/ppic.jpg'){
						$userc['pic_url'] = 'http://'.$ip.
																'/STFinal/res/'.'default/pictures/ppic.jpg';
					}else{
						$userd['pic_url'] = 'http://'.$ip.
																'/STFinal/res/users/U_'.
																md5($rowUser['schoolId']).'/profile'. '/'.$rowUser['pic_url'];
					}
					array_push($output,$userc);
			}
			echo json_encode(array("User" => $output),JSON_PRETTY_PRINT);
	}

}



?>
