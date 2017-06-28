<?php
/*
 * Calculates the most frequently occuring events and actions
 * in the knowledge base and returns them echoed as html
 */

//Require the connect function for the database
require_once('connect.php');
$conn = connect();
// Check it
if (!$conn){
	 die("Connection failed: " .  conn_connect_error());
 }
 $goodInfoQ = "SELECT * FROM good_story;";
 $results = executeQuery($goodInfoQ);
 $size = count($results);

 if($size != 0){
	 $eventArray = array();
	 $locationArray = array();
	 $actionArray = array();

	 foreach ($results as $row) {
		/*
		 *TODO: WHEN Multiple events/locations/actions used:
		 *Build an array in here out of individual entries (using split()) THEN add that array to eventArray/location/action
		 *
		 */
		 $eventArray[] = $row['event_sequence'];
		 $locationArray[] = $row['location_sequence'];
		 $actionArray[] = $row['action_sequence'];
	 }

	 /*Get the most popular event details*/
	 $e = array_count_values($eventArray);
	 $numOccurences = max($e);
	 $favouredEvent = array_search($numOccurences, $e); //TODO: No accounting for a tie
	 $eventInfo = "SELECT * FROM event WHERE event_id=$favouredEvent;";
	 $resultsE = executeQuery($eventInfo);
	 $sizeE = count($resultsE);
	 if($resultsE != 0){
	 	echo "<p>Most popular Event: <p class='text-danger'>".$resultsE[0]['brief']."</p>Number of occurences: <span class='text-danger'>".$numOccurences."</span></p>";
	}

	/*Get the most popular event details*/
	$a = array_count_values($actionArray);
	$favouredAction = array_search(max($a), $a);
	$actionInfo = "SELECT * FROM action WHERE ac_id=$favouredAction;";
	$resultsA = executeQuery($actionInfo);
	$sizeA = count($resultsA);
	if($resultsA != 0){
	 echo "<p>Most popular action: <p class='text-warning'>".$resultsA[0]['brief']."</p>Number of occurences: <span class='text-warning'>".max($a)."</span></p>";
 }


 /*Get the most popular location details*/
 $l = array_count_values($locationArray);
 $favouredLocation = array_search(max($l), $l);
 $locationInfo = "SELECT * FROM location WHERE loc_id=$favouredLocation;";
 $resultsL = executeQuery($locationInfo);
 $sizeL = count($resultsL);
 if($resultsL != 0){
	echo "<p>Most popular location: <p class='text-success'>".$resultsL[0]['name']."</p>Number of occurences: <span class='text-success'>".max($l)."</span></p>";
 }
}
?>
