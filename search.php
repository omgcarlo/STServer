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
    $queries = $_GET['queries'];    // Values to be searched
    $action = $_GET['action'];      // To specify what to search
    $imongId = $_GET['imo'];        // USER WHO WANTS TO SEARCH
      //  GET SERVER IP
    switch ($action) {
        case 'people':
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
                    $output = array();
                    while ($rowPost = mysqli_fetch_array($res)) {
                        $postc = array();
                        $postc['description'] = $rowPost['description'];
                        $postc['type'] = $rowPost['type'];
                        $postc['tags'] = $rowPost['tags'];
                        $postc['postId'] = $rowPost['postId'];
                        $postc['datetime'] = $post->getTimePast($rowPost['CreatedDate']);
                        if($rowPost['fileId'] != NULL ){
                             // KUNG NAAY FILE EDI KUHAON
                             $postc['fileId'] = $rowPost['fileId'];
                             include_once 'file.php';
                             $obj = new File();
                             $resFile = $obj->getFile($rowPost['fileId']);
                             $rowFile = mysqli_fetch_array($resFile);
                             $postc['fileUrl'] = $rowFile['fileUrl'];
                             $postc['fdescription'] = $rowFile['fdescription'];

                        }
                        // CALL TO USER CLASS
                        include_once 'user.php';
                        $user = new User();

                        $rowUser =mysqli_fetch_array($user->getUserDetails($rowPost['ownerId']));
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
                        array_push($output,$postc);
                    }
                        echo json_encode(array('Post' => $output),JSON_PRETTY_PRINT);
                }
            break;
        case 'discover':
              
        default:
            # code...
            break;
    }


 }


?>
