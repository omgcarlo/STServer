<?php
	include 'event.php';
	$event = new Event();
	$res = mysqli_query($conn,$event->displayAllEvents());
				if($res){
					$output = array();
					while($rowEvent = mysqli_fetch_array($res)){
						$eventc = array();
						$eventc['title'] = $rowEvent['event_title'];
						$eventc['description'] = $rowEvent['description'];
						$eventc['event_date'] = $rowEvent['event_date'];
						//	OWNER
						$eventc['username'] = $rowEvent['username'];
						$eventc['full_name'] = $rowEvent['full_name'];
						$eventc['pic_url'] = $rowEvent['pic_url'];
						array_push($output,$eventc);
					}
					$result = json_encode(array('Event' => $output),JSON_PRETTY_PRINT);
					echo $result;
				}
?>