<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json; charset=iso-8859-1');

// If the user session ID is set
if(isset($_POST['session_id']))
{
	// Get the user session ID
	$session_id=$_POST['session_id'];
	
	// Set the user session ID
	session_id($session_id);
}

include 'head.php';
include 'data_operations.php';

// Get the user belongs to the session
$user_id = read_from_session('session_user_id');

if(isset($_SESSION['session_user_id']) && $_SESSION['session_user_id'] == $user_id)
{
	// Set the typed event name parameter
	$event_name = $_POST['EventName'];

	// Set the typed event location parameter
	$event_location = $_POST['EventLocation'];

	// Set the typed event description parameter
	$event_description = $_POST['EventDescription'];

	// Set the typed event picture name
	$event_lost_picture_name = $_POST['EventLostPicName'];
	
	// Set the typed event picture data
	$event_lost_picture_data = $_POST['EventLostPicData'];

	// Check that all the required fields are not empty
	foreach(array($event_name, $event_location) as $new_event_details_property)
	{
		// If one or more of the required fields is empty
		if(empty($new_event_details_property))
		{
			// Notify the user about one or more empty required fields
			echo json_encode('אנא מלא את שדות השם והמקום');

			// Exit the operation
			exit();
		}
	}

	// Read the user id from the session
	$user_id = read_from_session('session_user_id');
	if(!$user_id)
	{
		echo json_encode('שם משתמש לא קיים');
		exit();
	}

	// Create a query to insert new event to the events table
	$insert_new_event="INSERT INTO `events` (`event_id`,`manager_id`,`event_name`,`s_time`,`e_time`,`description`,`place`, `search_areas_num`) 
					   VALUES (NULL, '$user_id', '$event_name', CURRENT_TIMESTAMP, NULL, '$event_description', '$event_location', 0)";

	// Insert new event to events table and get an array with the event id in it
	$response_arr = execute_sql_command($insert_new_event);

	// If table creation was successfull
	if($response_arr[1])
	{
		// Get the event id from the array
		$event_id = $response_arr[0];

		// Write the event id to the current session
		write_to_session('event_id',$event_id);	

		// Create directory for pictures and change permissions to allow access to pictures of the event
		mkdir("img/$event_id", 0777, true);
		
		$echoResult = "האירוע נוצר בהצלחה";
		
		// Send notifications to clients when a new event starts
		//include notification.php
		
		// Check if picture was sent
		if($event_lost_picture_data)
		{
			// Upload file to the server
			if(!upload_file($event_id, $event_lost_picture_name, $event_lost_picture_data))
			{
				// Notify the user about uploading failure
				$echoResult = "האירוע נוצר בהצלחה אך העלאת התמונה נכשלה";
			}
		}
		// Return success to manager
		echo json_encode("success ". $echoResult);
	}
	else
	{
		echo json_encode('פתיחת אירוע חדש נכשלה');
	}
}

?>