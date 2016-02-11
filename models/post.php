<?php
include_once 'dbs.php';
$dbs = new dbs();
$conn = $dbs->connect();

    /**
    *   (c) INCC Group  2015-2016
    *   EARLY TRAPPING!
    */
    if (mysqli_connect_errno($conn))
    {
       echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

class Post{
    private $conn;
	public function __construct(){
        $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
    public function insertPost($description,$type,$ownerId,$tags){
        $cdatet = date("Y-m-d")." ".date("h:i:s");
        $sql = "INSERT INTO `post`(`description`, `type`, `ownerId`, `tags`,`CreatedDate`) VALUES ('$description','$type','$ownerId','$tags','$cdatet')";
      //  die($sql);
        return mysqli_query($this->conn,$sql);
    }
    public function getFeed($userId){
        $sql = "Select * from post where ownerId = '$userId'";
        return mysqli_query($this->conn,$sql);
    }
    public function getPost($postId){
        $sql = "Select * from post JOIN user ON post.ownerId = user.schoolId where postId = $postId";
        return mysqli_query($this->conn,$sql);
    }
    public function getCountPost($ownerId){
        $sql = "SELECT count(*) as cpost from post where ownerId = $ownerId";
        return mysqli_query($this->conn,$sql);
    }
    public function getTimePast($d){
        $finaltime = "";
    		$current_date_time=date("Y-m-d h:i:s");
    		$now = new DateTime("$current_date_time");
    		$ref = new DateTime("$d");
    		$diff = $now->diff($ref);
    		//printf('%d days, %d hours, %d minutes', $diff->d, $diff->h, $diff->i);
    		if($diff->d > 0){
    			$finaltime .= $diff->d."d";
    		}
    		elseif($diff->h > 0){
    			$finaltime .= $diff->h. "h";
    		}
    		elseif($diff->i > 0){
    			$finaltime .= $diff->i."m";
    		}
    		else{
    			$finaltime .= $diff->s."s";
    		}
        return $finaltime;
    }
}

?>
