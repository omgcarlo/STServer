<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');

include 'models/report.php';
include 'models/post.php';
include 'models/comment.php';
$obj = new Report();
$post = new POST();
$comment = new Comment();
if(isset($_GET['action'])){
  $action = $_GET['action'];
  if($action == 'getReports'){
    $res = $obj->selectReportsDetails();
    $output = array();
    while($rowUser = mysqli_fetch_array($res)){
        $commentc = array();
        $commentc['repotId'] = $rowUser['reportId'];
        $commentc['reporter'] = $rowUser['full_name'];
        $commentc['referenceId'] = $rowUser['referenceId'];
        $commentc['referenceTable'] = $rowUser['referenceTable'];
        if($rowUser['referenceTable'] == 'post'){
          $resPost = $post->getPost($rowUser['referenceId']);
          $rowPost = mysqli_fetch_array($resPost);
          $commentc['Post owner'] = $rowPost['full_name'];
        }
        else if($rowUser['referenceTable'] == 'comment'){
          $resComment = $comment->selectComment($rowUser['referenceId']);
          $rowComment = mysqli_fetch_array($resComment);
          $commentc['Comment owner'] = $rowComment['full_name'];
        }
        $commentc['status'] = $rowUser['status'];
        $commentc['Date Reported'] = $rowUser['reportDate'];
        array_push($output,$commentc);
    }
    echo json_encode(array('Report' => $output),JSON_PRETTY_PRINT);
  }
  else if($action == 'insert'){
    $reporterId = $_POST['reporterId'];
    $referenceTable = $_POST['referenceTable'];
    $referenceId = $_POST['referenceId'];
    $res = $obj->insertReport($reporterId,$referenceTable,$referenceId);
    if($res)
      header("location:report.php?action=getReports");
    else
      echo 'Cancel';
  }
}
 ?>
