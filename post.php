<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');
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
 $obj = new Post();
if(isset($_POST['action'])){
	$action = $_POST['action'];
	//die($action);
	if ($action == 'new') {
        $description = $_POST['description'];
        $type = $_POST['type'];
        $ownerId = $_POST['ownerId'];
        $tags = $_POST['tags'];
        //echo $obj->insertPost($description,$type,$ownerId,$tags);
        $res = $obj->insertPost($description,$type,$ownerId,$tags);
        $postJSON = array();
        if($res){
            $postJSON['Success'] = true;
        }
        else{
            $postJSON['Success'] = false;
        }
          $output = json_encode(array('Post' => $postJSON),JSON_PRETTY_PRINT);
        echo $output;
    }
}
else{
    //else the action is GET
    $action = $_GET['action'];
    if($action == 'feed'){

        //  POST OWNER ID
        $ownerId = $_POST['ownerId'];
        /**
        *   select all post from following(User)
        *   following contains array of userIds
        */
        include_once 'user.php';
        $user = new User();
        //die($user->getUserDetails($ownerId));
        $post = new Post();
        $res = $user->getUserDetails($ownerId);
        if($res){
            $rowUser = mysqli_fetch_array($res);
            //  GET FOLLOWING IDS AND TRAVERSE EACH
            $ids = explode(",",$rowUser['following_ids']);

            $output = array();
            //die($ids[0]);
            //  FLEXIBLE QUERY
            $flex_query = "SELECT * FROM `post` Join user On post.ownerId = user.schoolId where post.ownerId = ";
            $sorting_q = " ORDER BY `CreatedDate` DESC";
            $q_ids =  "'$ownerId'";
            for($i = 0; $i < count($ids)-1; $i++){  //  -1 kay comma separated man
                $q_ids .= " OR post.ownerId = '$ids[$i]'";
            }
            // FINAL QUERY
            $fq = $flex_query.$q_ids.$sorting_q;
           //echo $fq;
            $res = mysqli_query($conn,$fq);
            if($res){
                while($rowPost = mysqli_fetch_array($res)){
                    $posti = array();
                    $posti['postId'] = $rowPost['postId'];
                    $posti['description'] = $rowPost['description'];
                    $posti['ownerId'] = $rowPost['ownerId'];
                    $posti['tags'] = $rowPost['tags'];
                    $posti['schoolId'] = $rowPost['schoolId'];
                    $posti['username'] = $rowPost['username'];
                    $posti['full_name'] = $rowPost['full_name'];
                    $posti['userType'] = $rowPost['UserType'];
                    $posti['datetime'] = $post->getTimePast($rowPost['CreatedDate']);
                    array_push($output,$posti);
                }
                echo json_encode(array('Post' => $output),JSON_PRETTY_PRINT);
            }


        }
    }
    elseif ($action == "getPost") {
      //  POST ID
      $postId = $_POST['postId'];

      $res = $obj->getPost($postId);

      $posti = array();

      if($res){
          $rowPost = mysqli_fetch_array($res);
          $posti['postId'] = $rowPost['postId'];
          $posti['description'] = $rowPost['description'];
          $posti['ownerId'] = $rowPost['ownerId'];
          $posti['tags'] = $rowPost['tags'];
          $posti['schoolId'] = $rowPost['schoolId'];
          $posti['username'] = $rowPost['username'];
          $posti['full_name'] = $rowPost['full_name'];
          $posti['userType'] = $rowPost['UserType'];
          $posti['datetime'] = $obj->getTimePast($rowPost['CreatedDate']);

          echo json_encode(array('Post' => $posti),JSON_PRETTY_PRINT);
      }
    }

}


?>
