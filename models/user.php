<?php
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
    $reg_date = date("Y-m-d")." ".date("h:i:s");
		$sql = "INSERT INTO user(schoolId,username,password,birthdate,email,programId,full_name,pic_url,registered_date)
            values('$schoolId','$username','$password','$birthdate','$email',$programId,'$full_name','$pic_url','$reg_date')";
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
  public function getUserId($username){
    //  Username is unique
    $sql = "SELECT schoolId from user where username = '$username'";
    return mysqli_query($this->conn,$sql);
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
  public function updatePicUrl($file,$schoolId){
    	$sql = "UPDATE user SET pic_url = '$file' WHERE schoolId = '$schoolId' ";
      return mysqli_query($this->conn,$sql);
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
?>
