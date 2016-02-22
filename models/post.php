<?php
include_once 'dbs.php';

    /**
    *   (c) INCC Group  2015-2016
    *   EARLY TRAPPING!
    */
class Post{
    private $conn;
	public function __construct(){
        $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
    public function insertPost($description,$type,$ownerId,$tags){
        $time=date("h:i:sa");
        $cdatet = date("Y-m-d")." ".date("G:i", strtotime($time));
        $temp = "";
        //  para di mo error kung naay '
        for($i = 0; $i < strlen($description); $i++ ){
          if($description[$i] == "'"){
            $temp .= $description[$i] . "";
          }
          $temp .= $description[$i];
        }
        $sql = "INSERT INTO `post`(`description`, `type`, `ownerId`, `tags`,`CreatedDate`) VALUES ('$temp','$type','$ownerId','$tags','$cdatet')";
        return mysqli_query($this->conn,$sql);
    }
    public function getFeed($userId){
        $sql = "Select * from post where ownerId = '$userId' and status = 'A'";
        return mysqli_query($this->conn,$sql);
    }
    public function getPost($postId){
        $sql = "Select * from post JOIN user ON post.ownerId = user.schoolId where postId = $postId";
        return mysqli_query($this->conn,$sql);
    }
    public function getCountPost($ownerId){
        $sql = "SELECT count(*) as cpost from post where ownerId = '$ownerId'";
        return mysqli_query($this->conn,$sql);
    }
    public function getPostId($description,$type,$ownerId){
       $sql = "SELECT postId from post where description = '$description' AND type = '$type' and ownerId = '$ownerId'";
       $rowPost = mysqli_fetch_array(mysqli_query($this->conn,$sql));
       return $rowPost['postId'];
    }
    public function upvote($userIds,$postId){
      $sql = "UPDATE post SET upvotes = '$userIds' where postId = $postId";
        //die($sql);
        return mysqli_query($this->conn,$sql);
    }
    public function uploadFile($fileId,$description,$type,$ownerId){
        $sql = "UPDATE post SET fileId = $fileId where description = '$description' AND type = '$type' and ownerId = '$ownerId'";
        return mysqli_query($this->conn,$sql);
    }
    public function getCountUpvotes($postId){
        $sql = "SELECT upvotes from post where postId = $postId";
        $rowPost = mysqli_fetch_array(mysqli_query($this->conn,$sql));
        $temp = explode(",",$rowPost['upvotes']);
        return count($temp) - 1;
    }
    public function extractNestedPost($description){
      //  Get postId hidden in description
      //	convert string to array
      $postId = preg_match("/share:(.*?):/", $description, $display);

    }
    public function deletePost($postId){
        $sql = "DELETE from post where postId = $postId";
        echo $sql;
        return mysqli_fetch_array($this->conn,$sql);
    }
    public function getTimePast($d){
        $finaltime = "";
    		$current_date_time=date("Y-m-d h:i:sa");
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
    public function isUpvoted($imongId,$iyangId){
      $ids = explode(",",$iyangId);
      $flag = false;
      //  TRAVERSE TO CHECK
      for($i = 0; $i < count($ids) - 1;$i++){
          if($ids[$i] == $imongId){
              $flag = true;
              break;
          }
      }
      return $flag;
    }
    public function isShared($imongId,$postId){
      $row = mysqli_fetch_array($this->getPost($postId));
      $flag = false;
      $ids = explode(",",$row['shares']);
      for($i = 0; $i < count($ids) - 1; $i++){
        if($ids[$i] == $imongId){
          $flag = true;
          break;
        }
      }
      return $flag;
    }

    public function countShares($postId){
      $row = mysqli_fetch_array($this->getPost($postId));
      $ids = explode(",",$row['shares']);
      return (count($ids)-1);
    }
    public function countUpVotes($postId){
      $row = mysqli_fetch_array($this->getPost($postId));
      $ids = explode(",",$row['upvotes']);
      return (count($ids)-1);
    }
}

?>
