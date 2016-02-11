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

class User{
	private $conn;
	public function __construct(){
		 $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
	public function login($username,$password){
		$sql = "Select * from user where schoolId = '$username' or username = '$username' and password = '$password'";
		return $sql;
	}

	public function signup($schoolId,$username,$password,$birthdate,
							$email,$programId,$full_name,$pic_url){
		$sql = "INSERT INTO user(schoolId,username,password,birthdate,email,programId,full_name,pic_url) values('$schoolId','$username','$password','$birthdate','$email',$programId,'$full_name','$pic_url')";
		return $sql;
	}
	public function selectUsers(){
		$sql = "SELECT * FROM user";
		return $sql;
	}
	public function selectUser($schoolId){
		$sql = "SELECT * FROM user WHERE schoolId = '$schoolId'";
    return mysqli_query($this->conn,$sql);
	}
	public function usersDetails(){
		$sql = "SELECT * FROM user JOIN program ON user.ProgramId = program.ProgramId, JOIN college ON program.CollegeCode = college.CollegeCode where user.Status = 'A' ";
		return mysqli_query($this->conn,$sql);
	}
    public function getUserDetails($userId){
        $sql = "Select * from user where schoolId = '$userId'";
        return mysqli_query($this->conn,$sql);
        //return $sql;
    }
	public function userDetails($userId){
		$sql = "SELECT * FROM user JOIN program ON user.programId = program.programId JOIN college ON program.CollegeCode = college.CollegeCode where user.status = 'A' AND user.schoolId = '$userId'";
    return mysqli_query($this->conn,$sql);
		//return $sql;
	}
	public function updateUser($schoolId,$username,$password,$email,$programId,$full_name,$pic_url){
		$sql = "UPDATE user SET username='$username' ,password='$password' ,email='$email' ,ProgramId='$programId' ,full_name='$full_name' ,pic_url='$pic_url' WHERE schoolId = '$schoolId'";
		return $sql;
	}
	public function deleteUser($userId){
		$sql = "DELETE FROM user WHERE schoolId = '$userId'";
	}
	public function updateStatus($userId){
		$sql = "UPDATE user SET status = 'D' WHERE schoolId = '$userId' ";
	}
	 public function addFollowing($imongId,$iyangId){
        $res = $this->getUserDetails($imongId);
        $rowUser = mysqli_fetch_array($res);
        //die($rowUser['following_ids']);

        if($rowUser['following_ids'] == null){
          //  I put a comma bacos the traversing function is -1
            $ids = $iyangId.",";
        }
        else{
            $ids = $rowUser['following_ids'].$iyangId. ",";
        }
        $this->addFollower($imongId,$iyangId);
        $sql = "UPDATE user SET following_ids = '$ids' where schoolId = '$imongId'";
        return mysqli_query($this->conn,$sql);
    }
    public function unfollow($imongId,$iyangId){
    	$res = $this->getUserDetails($imongId);
        $rowUser = mysqli_fetch_array($res);
        //die($rowUser['following_ids']);
        if($rowUser['following_ids'] == null){
            return false;
        }
        else{
            //$ids = $rowUser['following_ids'].$iyangId. ",";
            $fids = explode(",",$rowUser['following_ids']);
            $ids = "";
            if($fids[0] == ""){
              $sql = "UPDATE user SET following_ids = null where schoolId = '$imongId'";
              return mysqli_query($this->conn,$sql);
            }
        	for($i = 0; $i < count($fids); $i++){
        		if($fids[$i] == $iyangId){
              $this->deleteFollower($imongId,$iyangId);
        			continue;
        		}
            if($i == count($fids)-1  ){
                $ids .= $fids[$i];
            }
            else {
              $ids .= $fids[$i].",";
            }
        	}
        }
        $sql = "UPDATE user SET following_ids = '$ids' where schoolId = '$imongId'";
        return mysqli_query($this->conn,$sql);
    }
    public function addFollower($imongId,$iyangId){
      //  ANG IMONG ID KAY MABUTANG SA IYANG FOLLOWERS
      $res = $this->getUserDetails($iyangId);
      $rowUser = mysqli_fetch_array($res);
      //die($rowUser['following_ids']);
      if($rowUser['followers'] == null){
          $ids = $imongId.",";
      }
      else{
          $ids = $rowUser['followers'].$imongId. ",";
      }
      $sql = "UPDATE user SET followers = '$ids' where schoolId = '$iyangId'";
      return mysqli_query($this->conn,$sql);
    }
    public function deleteFollower($imongId,$iyangId){
    	$res = $this->getUserDetails($iyangId);
        $rowUser = mysqli_fetch_array($res);
        //die($rowUser['following_ids']);
        if($rowUser['followers'] == null){
            return false;
        }
        else{
            //$ids = $rowUser['following_ids'].$iyangId. ",";
            $fids = explode(",",$rowUser['followers']);
            $ids = "";
            if($fids[0] == "" || $fids[1] == "" ){
              $sql = "UPDATE user SET followers = null where schoolId = '$iyangId'";
              return mysqli_query($this->conn,$sql);
            } else {
              for($i = 0; $i < count($fids); $i++){
            		if($fids[$i] == $imongId){
            			continue;
            		}
                if($i == count($fids)-1  ){
            		    $ids .= $fids[$i];
                }
                else {
                  $ids .= $fids[$i].",";
                }
            	}
            }
        }
        $sql = "UPDATE user SET followers = '$ids' where schoolId = '$iyangId'";
        return mysqli_query($this->conn,$sql);
    }
    public function isFollowed($imongId,$iyangId){
        $rowUser = mysqli_fetch_array($this->getUserDetails($imongId));
        $fids = explode(",",$rowUser['following_ids']);
        for($i = 0; $i < count($fids);$i++){
            if($fids[$i] == $iyangId){
              return true;
            }
        }
        return false;
    }
}
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
      include_once 'activity.php';
      $act = new Activity();
      $desc = "followed";
      $act->insertActivity($imongId,$desc,$iyangId);
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
