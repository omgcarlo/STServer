<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type');
header('Content-Type: application/json');
  include 'models/events.php';
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
