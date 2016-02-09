<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');
include_once 'dbs.php';
$dbs = new dbs();
$conn = $dbs->connect();
/**
*   (c) INCC Group 2015-2016
*   EARLY TRAPPING!
*/
if (mysqli_connect_errno($conn))
{
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

class Search{
    private $conn;
	public function __construct(){
       $dbs = new dbs();
       $this->conn = $dbs->connect();
	}
	public function searchPerson($params,$imongId){
        $sql = "Select * from user where (schoolId <> '$imongId' AND username like '%$params%') OR (schoolId <> '$imongId' AND full_name like '%$params%')";
        return mysqli_query($this->conn,$sql);
    }
    public function searchTopics($params1,$params2){
        $sql = "Select * from post where tags like '%$params1%' OR description like '%$params1%' OR tags like '%$params2%' OR description like '%$params2%'";
        return mysqli_query($this->conn,$sql);
    }

}
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
                        $userc['pic_url'] = $rowUser['pic_url'];
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
                    $output = array();
                    while ($rowPost = mysqli_fetch_array($res)) {
                        $postc = array();
                        $postc['description'] = $rowPost['description'];
                        $postc['type'] = $rowPost['type'];
                        $postc['tags'] = $rowPost['tags'];
                        $postc['postId'] = $rowPost['postId'];
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
                        $postc['pic_url'] = $rowUser['pic_url'];
                        $postc['UserType'] = $rowUser['UserType'];
                        $postc['username'] = $rowUser['username'];
                        $postc['isFollowed'] = $user->isFollowed($imongId,$rowUser['schoolId']);

                        array_push($output,$postc);
                    }
                        echo json_encode(array('Post' => $output),JSON_PRETTY_PRINT);
                }
            break;
        default:
            # code...
            break;
    }


 }


?>
