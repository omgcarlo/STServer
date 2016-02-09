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

class Comment{
    private $conn;
  	public function __construct(){
          $dbs = new dbs();
          $this->conn = $dbs->connect();
  	}
    public function insertComment($postId,$userId,$comment){
      $sql = "INSERT INTO comment(postId,userId,comment) Values($postId,'$userId','$comment')";
      return mysqli_query($this->conn,$sql);
    }
    public function selectAllComment($postId){
      //  GET ALL COMMENT FROM SINGLE POST
      $sql = "SELECT * from comment where postId = '$postId'";
      return mysqli_query($this->conn,$sql);
    }
    public function approvedComment($commentId){
        $sql = "UPDATE comment SET isApproved = 1 where commentId = $commentId ";
        return mysqli_query($this->conn,$sql);
    }

}
 $obj = new Comment();
if(isset($_POST['action'])){
	$action = $_POST['action'];
	//die($action);
	if ($action == 'new') {
        $postId = $_POST['postId'];
        $userId = $_POST['userId'];
        $comment = $_POST['comment'];
        //echo $obj->insertPost($description,$type,$ownerId,$tags);
        $res = $obj->insertComment($postId,$userId,$comment);

        $postJSON = array();
        if($res){
            $postJSON['Success'] = true;
            //  ADD ACTIVITY
            include_once 'activity.php';
            $act = new Activity();
            $desc = "commented";
            $act->insertActivity($userId,$desc,$postId);
        }
        else{
            $postJSON['Success'] = false;
        }
          $output = json_encode(array('Comment' => $postJSON),JSON_PRETTY_PRINT);
        echo $output;
    }
}
else{
    //else the action is GET
    $action = $_GET['action'];
    if($action == 'getcomments'){

        //  POST OWNER ID
        $postId = $_POST['postId'];
        $res = $obj->selectAllComment($postId);
        /**
        *   select all post from following(User)
        *   following contains array of userIds
        */
        include_once 'user.php';
        $user = new User();
        $output = array();
        //die($user->getUserDetails($ownerId));

        while($rowComment = mysqli_fetch_array($res)){
            $commentc = array();
            $commentc['postId'] = $rowComment['postId'];
            $commentc['comment'] = $rowComment['comment'];
            if($rowComment['isApproved'] == '0'){
                $commentc['isApproved'] = false;
            }
            else {
                $commentc['isApproved'] = true;
            }

            $commentc['status'] = $rowComment['status'];

            $rowUser = mysqli_fetch_array($user->getUserDetails($rowComment['userId']));

            $commentc['schoolId'] = $rowUser['schoolId'];
            $commentc['Name'] = $rowUser['full_name'];
            $commentc['Username'] = $rowUser['username'];
            $commentc['UserType'] = $rowUser['UserType'];
            array_push($output,$commentc);
        }
        echo json_encode(array('Comment' => $output),JSON_PRETTY_PRINT);



    }

}


?>
