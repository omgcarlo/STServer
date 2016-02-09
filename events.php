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
class Event{
	  private $conn;
	public function __construct(){
        $dbs = new dbs();
        $this->conn = $dbs->connect();
	}
	public function insertEvent($datedata,$title,$description,$ownerId){
		$sql = "INSERT into event(createdBy,event_title,description,event_date) VALUES('$ownerId','$title','$description','$datedata')";
		return mysqli_query($this->conn,$sql);
		//return $sql;
	}
	public function displayAllEvents(){
		$sql = "SELECT createdBy,fileId,event_title,description,event_date,username,full_name,pic_url from event join user on event.createdBy = user.schoolId";
		return mysqli_query($this->conn,$sql);
	}
  public function getEvent($edate){
    $sql = "Select * from event where event_date = '$edate'";
    return mysqli_query($this->conn,$sql);
  }
  public function getUpcomingEvents($edate,$udate){
    $sql = "SELECT * from event where event_date BETWEEN '$edate' AND '$udate' ORDER BY `event`.`event_date` ASC";
    return mysqli_query($this->conn,$sql);
  }
}
	$obj = new Event();
	if(isset($_GET['action'])){
		$action = $_GET['action'];
		if($action == 'new'){
			//echo $obj->insertEvent($_POST['edate'],$_POST['etitle'],$_POST['edescription'],$_POST['ownerId']);
			$res = $obj->insertEvent($_POST['edate'],$_POST['etitle'],$_POST['edescription'],$_POST['ownerId']);
			$eventJSON = array();
			if ($res) {
				$eventJSON['Success'] = true;
			}
			else{
				$eventJSON['Success'] = false;
			}
			 $output = json_encode(array('Event' => $eventJSON),JSON_PRETTY_PRINT);
        	 echo $output;
		}
		else if($action == 'update'){}
    else if ($action == 'getEvent') {
          //  GET SPECIFIC EVENT
          $edate = $_POST['edate'];

          $res = $obj->getEvent($edate);
          if($res){
            $output2 =array();
            while($rowEvent = mysqli_fetch_array($res)){
                if($rowEvent['eventId'] != null){
                   $output = array();
                    $output['event_id'] = $rowEvent['eventId'];
                    $output['Title'] = $rowEvent['event_title'];
                    $output['description'] = $rowEvent['description'];
                    $output['event_date'] = $rowEvent['event_date'];
                    array_push($output2,$output);
                }
            }
            echo json_encode(array('Event' => $output2),JSON_PRETTY_PRINT);
          }
    }
    else if($action == 'getUpcomingEvents'){
        //GET UPCOMING Events
        $edate = $_POST['edate'];
        $temp_date = explode("-",$edate);
        //  0 = year | 1 = month |
        if($temp_date[1] >= 12){
            // TO JANUARY
          $udate = ($temp_date[0]+1).'-01-'.$temp_date[2];
        }
        else{
          $udate = $temp_date[0].'-'.($temp_date[1]+1).'-'.$temp_date[2]; // BETWEEN the date and edate+30days
        }
        //die($edate.$udate);
        $res = $obj->getUpcomingEvents($edate,$udate);
        if($res){
          $output = array();
          while($rowEvent = mysqli_fetch_array($res)){
            $eventc = array();
            $eventc['event_id']= $rowEvent['eventId'];
            $eventc['Title'] = $rowEvent['event_title'];
            $eventc['description'] = $rowEvent['description'];
            $eventc['event_date'] = $rowEvent['event_date'];
            array_push($output,$eventc);
          }
          echo json_encode(array('Event' => $output),JSON_PRETTY_PRINT);
        }
    }
		else if($action == 'delete'){}
			else {
				$res = $obj->displayAllEvents();
				if($res){
					$output = array();
					while($rowEvent = mysqli_fetch_array($res)){
						$eventc = array();
            $eventc['event_id']= $rowEvent['eventId'];
						$eventc['title'] = $rowEvent['event_title'];
						$eventc['description'] = $rowEvent['description'];
						$eventc['event_date'] = $rowEvent['event_date'];
						array_push($output,$eventc);
					}
					echo json_encode(array('Event' => $output),JSON_PRETTY_PRINT);
				}

			}
	}
?>
