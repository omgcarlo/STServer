<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');

ini_set('upload_max_size' , '32M');
ini_set('post_max_size', '32M');

include 'models/post.php';
$obj = new Post();
if(isset($_POST['action'])){
	$action = $_POST['action'];
	//die($action);
	if ($action == 'new') {
				if(isset($_GET['share'])){
					//	GET POST ID PARA E SHARE
					$shareId = $_GET['share'];
					$description = "::share:". $shareId."::".$_POST['description'];
				}
				else{
					$description = $_POST['description'];
				}
        $type = $_POST['type'];
        $ownerId = $_POST['ownerId'];
        $tags = $_POST['tags'];

        //echo $obj->insertPost($description,$type,$ownerId,$tags);
        $res = $obj->insertPost($description,$type,$ownerId,$tags);
				$postId = $obj->getPostId($description,$type,$ownerId);
        $postJSON = array();
        if($res){
					if(isset($_FILES['uploaded_file']) && !is_null($_FILES['uploaded_file']) && $_FILES['uploaded_file']['size'] != 0){
							$rootDir = "../res/users/"."U_". md5($ownerId);
							$fileDir = $rootDir."/files";
							$target_path1 = $fileDir . "/";
							//	count the files
							$countFiles = new FilesystemIterator($target_path1, FilesystemIterator::SKIP_DOTS);
							$extension = explode(".",basename( $_FILES['uploaded_file']['name']));
							//echo $countFiles;
							// 	rename the file
							$new_name = "F_". md5(iterator_count($countFiles)) .".". $extension[1];
							$target_path1 = $target_path1 . $new_name;
							if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path1)) {
										include_once 'models/file.php';
										$file = new File();
										$file->insertFile($new_name,$ownerId,$type,basename( $_FILES['uploaded_file']['name']));
										$rowFile = mysqli_fetch_array($file->getFileId($new_name,$ownerId));
										$res = $obj->uploadFile($rowFile['fileId'],$description,$type,$ownerId);	//	UPDATE PIC URL
										if ($res) {
												$postJSON["UploadSuccess"] = true;
										} else{
												$postJSON["UploadSuccess"] = false;
												$obj->deletePost($postId);
										}
							}
							else{
								$postJSON["UploadSuccess"] = false;
								$obj->deletePost($postId);
								echo "postDEleted";
							}
					}
					//	INSERT MENTIONS
					include_once 'models/mention.php';
					$mention = new Mention();
					include_once 'models/user.php';
					$user = new User();
					$usernames = $mention->extractUsers($description);	//	extract
					for($i = 0 ; $i < count($usernames) -1 ; $i++){

						if($usernames[$i] != ""){
								//echo $usernames[$i] . " " . $i;
								$rowUser = mysqli_fetch_array($user->getUserId($usernames[$i]));
								$mention->insertMention($ownerId,"post",$postId,$rowUser['schoolId']);
								//  ADD ACTIVITY
								include_once 'models/activity.php';
								$act = new Activity();
								$desc = "tagged";
								$act->insertActivity($ownerId,$desc,$postId);
								//  ADD NOTIFICATION
								include_once 'models/notification.php';
								$notif = new Notification();
								$post = new Post();
								$rowPost = mysqli_fetch_array($post->getPost($postId));
								$notif->insertNotification($rowUser['schoolId'],"post","tagged",$postId,$ownerId);
						}

					}
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
        include_once 'models/user.php';
        $user = new User();
        include_once 'models/comment.php';
				$comment = new Comment();
        $post = new Post();
        $res = $user->getUserDetails($ownerId);
        if($res){
            $rowUser = mysqli_fetch_array($res);
            //  GET FOLLOWING IDS AND TRAVERSE EACH
            $ids = explode(",",$rowUser['following_ids']);

            $output = array();
            //die($ids[0]);
            //  FLEXIBLE QUERY
            $flex_query = "SELECT * FROM `post` Join user On post.ownerId = user.schoolId where post.status = 'A' AND post.ownerId = ";
            $sorting_q = " ORDER BY `CreatedDate` DESC";
            $q_ids =  "'$ownerId'";
            for($i = 0; $i < count($ids)-1; $i++){  //  -1 kay comma separated man
                $q_ids .= " OR post.status = 'A' AND post.ownerId = '$ids[$i]'";
            }
            // FINAL QUERY
            $fq = $flex_query.$q_ids.$sorting_q;
           	//echo $fq;
            $res = mysqli_query($conn,$fq);
            if($res){
                while($rowPost = mysqli_fetch_array($res)){
                    $posti = array();
										$extratedPost = $obj->extractNestedPost($rowPost['description']);	//GET postId
										if($extratedPost != "wala"){
											$rowShare = mysqli_fetch_array($obj->getPost($extratedPost));
											$rowShareUser = mysqli_fetch_array($user->getUserDetails($rowShare['ownerId']));
											$posti['share_postId'] = $rowShare['postId'];
											$posti['share_description'] = $rowShare['description'];
											$posti['share_username'] = $rowShare['username'];
											$posti['share_full_name'] = $rowShare['full_name'];
											$posti['share_userType'] = $rowShare['UserType'];
											if($rowShare['pic_url'] == 'default/pictures/ppic.jpg'){
												$posti['share_pic_url'] = 'http://'.$ip.
																						'/STFinal/res/'.'default/pictures/ppic.jpg';
											}else{
												$posti['share_pic_url'] = 'http://'.$ip.
																						'/STFinal/res/users/U_'.
																						md5($rowShare['ownerId']).'/profile'. '/'.$rowShare['pic_url'];
											}
											//hide the share in description
											$desc = preg_replace("/::share:(.*?)::/","",$rowPost['description']);
										}
										else{
											$desc = $rowPost['description'];
										}
                    $posti['postId'] = $rowPost['postId'];
                    $posti['description'] = $desc;

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
                echo json_encode(array('Post' => $output),JSON_PRETTY_PRINT);
            }
        }
    }
    elseif ($action == "getPost") {
      //  POST ID
      $postId = $_POST['postId'];
			$ownerId = $_POST['ownerId'];
			include_once 'models/comment.php';
			$comment = new Comment();
			include_once 'models/user.php';
			$user = new User();
      $res = $obj->getPost($postId);

      $posti = array();

      if($res){
          $rowPost = mysqli_fetch_array($res);
          $posti['postId'] = $rowPost['postId'];
					$extratedPost = $obj->extractNestedPost($rowPost['description']);	//GET postId
					if($extratedPost != "wala"){
						$rowShare = mysqli_fetch_array($obj->getPost($extratedPost));
						$rowShareUser = mysqli_fetch_array($user->getUserDetails($rowShare['ownerId']));
						$posti['share_postId'] = $rowShare['postId'];
						$posti['share_description'] = $rowShare['description'];
						$posti['share_username'] = $rowShare['username'];
						$posti['share_full_name'] = $rowShare['full_name'];
						$posti['share_userType'] = $rowShare['UserType'];
						if($rowShare['pic_url'] == 'default/pictures/ppic.jpg'){
							$posti['share_pic_url'] = 'http://'.$ip.
																	'/STFinal/res/'.'default/pictures/ppic.jpg';
						}else{
							$posti['share_pic_url'] = 'http://'.$ip.
																	'/STFinal/res/users/U_'.
																	md5($rowShare['ownerId']).'/profile'. '/'.$rowShare['pic_url'];
						}
						//hide the share in description
						$desc = preg_replace("/::share:(.*?)::/","",$rowPost['description']);
					}
					else{
						$desc = $rowPost['description'];
					}
					$posti['description'] = $desc;
          $posti['ownerId'] = $rowPost['ownerId'];
          $posti['tags'] = $rowPost['tags'];
          $posti['schoolId'] = $rowPost['schoolId'];
          $posti['username'] = $rowPost['username'];
          $posti['full_name'] = $rowPost['full_name'];
          $posti['userType'] = $rowPost['UserType'];
          $posti['datetime'] = $obj->getTimePast($rowPost['CreatedDate']);
					$posti['isOwned'] = $rowPost['schoolId'] == $ownerId;
					$posti['isUpvoted'] = $obj->isUpvoted($ownerId,$rowPost['upvotes']);
					$posti['isShared'] = $obj->isShared($ownerId,$rowPost['postId']);
					$posti['upvotes'] = $obj->countUpVotes($rowPost['postId']);
					$posti['shares'] = $obj->countShares($rowPost['postId']);
					$posti['comments'] = $comment->countComments($rowPost['postId']);
					if($rowPost['pic_url'] == 'default/pictures/ppic.jpg'){
						$posti['pic_url'] = 'http://'.$ip.
																'/STFinal/res/'.$rowPost['pic_url'];
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
          echo json_encode(array('Post' => $posti),JSON_PRETTY_PRINT);
      }
    }
		elseif ($action == 'upvote') {
				$postId = $_POST['postId'];
				$userId = $_POST['ownerId'];
				//die($postId ." ".$userId);
				$upvotes = "";  //  INIT UPVOTE
				//  THIS ALGORITHM IS SMART
				$post = new Post();
				$rowPost = mysqli_fetch_array($post->getPost($postId)); // GET POST DETAILS
				//  check if NULL
				//die($rowPost['upvotes']);
				if($rowPost['upvotes'] != NULL || $rowPost['upvotes'] != "" || $rowPost['upvotes'] != null){
					$temp = explode(",",$rowPost['upvotes']);
					//  CHECK IF NI UPVOTE NA BA
					$flag = false;

					for($i = 0; $i < count($temp) -1; $i++){
							if($temp[$i] == $userId){
									$flag = true;
									break;
							}
					}
					if(!$flag){
						//  APPEND NEW ID
						$upvotes = $rowPost['upvotes'] . $userId . ",";
					}
					else{
						//  if exist in upvote array
						//  then unvote
						if($rowPost['upvotes'] == NULL || count($temp) <= 1)
							$upvotes = NULL;
						else {
							for($i = 0; $i < count($temp) -1; $i++){
									if($temp[$i] == $userId){
											continue;
									}
									$upvotes .= $temp[$i] . ",";
									//echo $temp[$i] . " - " . $userId . " | ";
							}
						}
					}
				}
				else{
					$upvotes = $userId . ",";
				}
				//echo $upvotes;
				$res = $obj->upvote($upvotes,$postId);
				$output = array();
				if($res){
					$output['Success'] = true;
				}
				else{
					$output['Success'] = false;
				}
				echo json_encode(array('Post' => $output),JSON_PRETTY_PRINT);
		}
	/*	else if($action == 'share'){
				$description = "share:". $_POST['postId'] . ":" .$_POST['description'] ;
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
				echo json_encode(array("Post" => $postJSON),JSON_PRETTY_PRINT);
		}*/
		else if($action == 'upload_file'){
				$description = $_GET['description'];
				$type = $_GET['type'];
				$ownerId = $_GET['ownerId'];
				$tags = $_GET['tags'];

				$postId = $obj->getPostId($description,$type,$ownerId);
				if(isset($_FILES['uploaded_file']) && !is_null($_FILES['uploaded_file']) && $_FILES['uploaded_file']['size'] != 0){
						$rootDir = "../res/users/"."U_". md5($ownerId);
						$fileDir = $rootDir."/files";
						$target_path1 = $fileDir . "/";
						//	count the files
						$countFiles = new FilesystemIterator($target_path1, FilesystemIterator::SKIP_DOTS);
						$extension = explode(".",basename( $_FILES['uploaded_file']['name']));
						//echo $countFiles;
						// 	rename the file
						$new_name = "F_". md5(iterator_count($countFiles)) .".". $extension[1];
						$target_path1 = $target_path1 . $new_name;
						if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_path1)) {
									include_once 'models/file.php';
									$file = new File();
									$file->insertFile($new_name,$ownerId,$type,basename($_FILES['uploaded_file']['name']));
									$rowFile = mysqli_fetch_array($file->getFileId($new_name,$ownerId));
									$res = $obj->uploadFile($rowFile['fileId'],$description,$type,$ownerId);	//	UPDATE PIC URL
									if ($res) {
											$postJSON["UploadSuccess"] = true;
									} else{
											$postJSON["UploadSuccess"] = false;
											$obj->deletePost($postId);
									}
						}
						else{
							$postJSON["UploadSuccess"] = false;
							$obj->deletePost($postId);
							//echo "postDEleted";
						}
				}
		}

}


?>
