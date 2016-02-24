<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');
include 'models/search.php';

    /**
    *   This is for the search function
    *   Hence, functions should be using GET method
    *   ============================================
    *   This function is a mixture of all tables
    */
 $obj = new Search();
 if(isset($_POST['queries'])){
    die('wara');
 }
 if(isset($_GET['queries'])){
   $action = $_GET['action'];    // To specify what to search
    switch ($action) {
        case 'people':
        $queries = $_GET['queries'];    // Values to be searched
        $imongId = $_GET['imo'];        // USER WHO WANTS TO SEARCH
            $res = $obj->searchPerson($queries,$imongId);
               if ($res) {
                    include_once 'user.php';
                    $user = new User();

                    $output = array();
                    while ($rowUser = mysqli_fetch_array($res)) {
                        $userc = array();
                        $userc['full_name'] = $rowUser['full_name'];
                        $userc['schoolId']  = $rowUser['schoolId'];
                        if($rowUser['pic_url'] == 'default/pictures/ppic.jpg'){
                          $userc['pic_url'] = 'http://'.$ip.
                                              '/STFinal/res/'.'default/pictures/ppic.jpg';
                        }else{
                          $userc['pic_url'] = 'http://'.$ip.
                                              '/STFinal/res/users/U_'.
                                              md5($rowUser['schoolId']).'/profile'. '/'.$rowUser['pic_url'];
                        }
                        $userc['UserType'] = $rowUser['UserType'];
                        $userc['username'] = $rowUser['username'];
                        $userc['isFollowed'] = $user->isFollowed($imongId,$rowUser['schoolId']);

                        //  GET COUNT FOR FOLLOWING
                        if($rowUser['following_ids'] == NULL){
                          $following = 0;
                        }
                        else{
                          $ids = explode(",",$rowUser['following_ids']);
                          $following = count($ids) - 1;
                        }
                        //  GET COUNT FOR FOLLOWING
                        if($rowUser['followers'] == NULL){
                          $followers = 0;
                        }
                        else{
                          $ids = explode(",",$rowUser['followers']);
                          $followers = count($ids) - 1;
                        }

                        $userc['followers'] = $followers;
                        $userc['following'] = $following;
                        array_push($output,$userc);
                    }
                        echo json_encode(array('User' => $output),JSON_PRETTY_PRINT);
                }
            break;
        case 'topics':
            /*    I CALL THIS THE LAST 2 WORDS ALGORITHM
            *     GETTING THE LAST 2 WORDS
            *     PUT IT TO QUERY
            */
            $queries = $_GET['queries'];    // Values to be searched
            $imongId = $_GET['imo'];        // USER WHO WANTS TO SEARCH

            $q = explode(" ",$queries);
            $lastword = $q[(count($q)-1)];
            if((count($q)-2) < 0 ){
              $slastword =  $lastword;
            }
            else{
                $slastword =  $q[(count($q)-2)];  //Second to the last word
            }
            //die($lastword." | ".$slastword );
            $res = $obj->searchTopics($lastword ,$slastword);

            if ($res) {
                include_once 'models/post.php';
                $post = new Post();
                include_once 'user.php';
                $user = new User();
                include_once 'models/file.php';
                $file = new File();
                include_once 'models/comment.php';
                $comment = new Comment();
                    $output = array();
                    while ($rowPost = mysqli_fetch_array($res)) {
                        $postc = array();
                        $postc['description'] = $rowPost['description'];
                        $postc['type'] = $rowPost['type'];
                        $postc['tags'] = $rowPost['tags'];
                        $postc['postId'] = $rowPost['postId'];

                        $rowUser = mysqli_fetch_array($user->getUserDetails($rowPost['ownerId']));
                        if($rowPost['fileId'] != NULL ){
                             // KUNG NAAY FILE EDI KUHAON
                             $postc['fileId'] = $rowPost['fileId'];
                             include_once 'models/file.php';
                             $obj = new File();
         											$rowFile = mysqli_fetch_array($file->getFile($rowPost['fileId']));
         											$postc['file_description'] = $rowFile['description'];
         											$postc['file_url'] = 'http://'.$ip.
         																					'/STFinal/res/users/U_'.
         																					md5($rowUser['schoolId']).'/files'. '/'.$rowFile['fileUrl'];

                        }	else {
                            $postc['file_url'] = "nofile";
                            $postc['file_description'] = "nofile";
                          }
                        // get user details

                        $postc['full_name'] = $rowUser['full_name'];
                        $postc['schoolId']  = $rowUser['schoolId'];
                        if($rowUser['pic_url'] == 'default/pictures/ppic.jpg'){
                          $postc['pic_url'] = 'http://'.$ip.
                                              '/STFinal/res/'.$rowUser['pic_url'];
                        }else{
                          $postc['pic_url'] = 'http://'.$ip.
                                              '/STFinal/res/users/U_'.
                                              md5($rowUser['schoolId']).'/profile'. '/'.$rowUser['pic_url'];
                        }
                        $postc['UserType'] = $rowUser['UserType'];
                        $postc['username'] = $rowUser['username'];

                        $postc['isFollowed'] = $user->isFollowed($imongId,$rowUser['schoolId']);
                        $postc['isOwned'] = $rowUser['schoolId'] == $imongId;

                        $postc['datetime'] = $post->getTimePast($rowPost['CreatedDate']);
    										$postc['isOwned'] = $rowUser['schoolId'] == $imongId;
    										$postc['isUpvoted'] = $post->isUpvoted($imongId,$rowPost['upvotes']);
    										$postc['isShared'] = $post->isShared($imongId,$rowPost['postId']);
    										$postc['upvotes'] = $post->countUpVotes($rowPost['postId']);
    										$postc['shares'] = $post->countShares($rowPost['postId']);
    										$postc['comments'] = $comment->countComments($rowPost['postId']);
                        array_push($output,$postc);
                    }
                        echo json_encode(array('Post' => $output),JSON_PRETTY_PRINT);
                }
            break;
        case 'discoverNotes':
                include_once 'models/college.php';
                $college = new College();
                include_once 'models/post.php';
                $post = new Post();
                include_once 'models/user.php';
                $user = new User();

                $squeries = $_GET['queries'];
                $cno = $_GET['courseNo']; // COURSE NO.
                $res = $obj->discoverNotes($squeries,$cno);
                $output = array();
                while($rowSearch = mysqli_fetch_array($res)){
                  $discover = array();
                  $discover['Type'] = "Note";
                  $discover['ownerId'] = $rowSearch['OwnerId'];
                  $rowUser = mysqli_fetch_array($user->getUserDetails($rowSearch['OwnerId']));
                  $discover['full_name'] = $rowUser['full_name'];
                  $discover['note_description'] = $rowSearch['Description'];
                  $discover['file_description'] = $rowSearch['description'];
                  $discover['datetime'] = $post->getTimePast($rowSearch['CreatedDate']);
                  //  get course details
                  $course = $college->getCollegeCodeFromCourse($rowSearch['CourseId']);
                  $discover['fileUrl'] = "http://".$ip."/STFinal/res/notes/C_".$course['CollegeCode']."/".$course['courseNo']."/".$rowSearch['fileUrl'];
                  array_push($output,$discover);
                }
                echo json_encode(array('Discover' => $output),JSON_PRETTY_PRINT);
            break;
        case 'discoverTopics':
              include_once 'models/college.php';
              $college = new College();
              include_once 'models/post.php';
              $post = new Post();
              include_once 'models/comment.php';
              $comment = new Comment();
              $squeries = $_GET['queries'];
              $ownerId = $_GET['imo'];
              $cno = $_GET['courseNo']; // COURSE NO.
              $res = $obj->discoverTopics($squeries,$cno);
              $output = array();
              while($rowPost = mysqli_fetch_array($res)){
                  $posti = array();
                  $posti['postId'] = $rowPost['postId'];
                  $posti['description'] = $rowPost['description'];
                  if($rowPost['description'] )
                  $posti['ownerId'] = $rowPost['ownerId'];
                  $posti['tags'] = $rowPost['tags'];
                  $posti['schoolId'] = $rowPost['schoolId'];
                  $posti['username'] = $rowPost['username'];
                  $posti['full_name'] = $rowPost['full_name'];
                  $posti['userType'] = $rowPost['UserType'];
                  if($rowPost['pic_url'] == 'default/pictures/ppic.jpg'){
                    $posti['pic_url'] = 'http://'.$ip.
                                        '/STFinal/res/'.'default/pictures/ppic.jpg';
                  }else{
                    $posti['pic_url'] = 'http://'.$ip.
                                        '/STFinal/res/users/U_'.
                                        md5($rowPost['schoolId']).'/profile'. '/'.$rowPost['pic_url'];
                  }
                  if ($rowPost['fileId'] != "" || $rowPost['fileId'] != NULL ) {
                    include_once 'models/file.php';
                    $file = new File();
                    $rowFile = mysqli_fetch_array($file->getFile($rowPost['fileId']));
                    $posti['file_description'] = $rowFile['description'];
                    $posti['file_url'] = 'http://'.$ip.
                                        '/STFinal/res/users/U_'.
                                        md5($rowPost['schoolId']).'/files'. '/'.$rowFile['fileUrl'];
                  }
                  else{
                    $posti['file_url'] = "nofile";
                    $posti['file_description'] = "nofile";
                  }

                  $posti['datetime'] = $post->getTimePast($rowPost['CreatedDate']);
                  $posti['isOwned'] = $rowPost['schoolId'] == $ownerId;
                  $posti['isUpvoted'] = $post->isUpvoted($ownerId,$rowPost['upvotes']);
                  $posti['isShared'] = $post->isShared($ownerId,$rowPost['postId']);
                  $posti['upvotes'] = $post->countUpVotes($rowPost['postId']);
                  $posti['shares'] = $post->countShares($rowPost['postId']);
                  $posti['comments'] = $comment->countComments($rowPost['postId']);
                  array_push($output,$posti);
              }
              echo json_encode(array('Discover' => $output),JSON_PRETTY_PRINT);
        default:
            //  HELP
            //get user's course
            $squeries = $_GET['queries'];
            $cno = $_GET['courseNo'];       // COURSE NO.
            $output = array();
            while($rowSearch = mysqli_fetch_array($obj->searchQuestions($squeries,$cno))){
                $searchi = array();
                $searchi[''] = $rowSearch[''];
            }

            break;
          }
    }
    else{
      $action = $_GET['action'];

    }




?>
