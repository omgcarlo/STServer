<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');

include 'models/comment.php';
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

            //  ADD ACTIVITY
            include_once 'models/activity.php';
            $act = new Activity();
            $desc = "commented";
            $act->insertActivity($userId,$desc,$postId);
            //  ADD NOTIFICATION
            include_once 'models/notification.php';
            $notif = new Notification();
            include_once 'models/post.php';
            $post = new Post();
            $rowPost = mysqli_fetch_array($post->getPost($postId));
            $notif->insertNotification($rowPost['ownerId'],"post","commented",$postId,$userId);
            $postJSON['Success'] = true;
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
