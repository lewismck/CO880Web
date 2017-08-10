<?php
/*
 * evaluate a story as good or bad depending on the 'r' flag
 * and put it's info into the appropriate table
 */

//Require the connect function for the database
require_once('connect.php');
$conn = connect();
// Check it
if (!$conn){
   die("Connection failed: " .  conn_connect_error());
 }

if(isset($_GET['r'])){
  $rating = $_GET['r'];
  $eventSequence = $_GET['event'];
  $locationSequence = $_GET['loc'];
  $actionSequence = $_GET['action'];

  /*If 'r' parameter in _GET request is g for good put story details into good_story table*/
  if($rating == 'g'){
    $sql = "INSERT INTO good_story (event_sequence, location_sequence, action_sequence) VALUES('$eventSequence', '$locationSequence', '$actionSequence');";
    $handle = $conn->prepare($sql);
    $handle->execute();

    echo "<p class='text-info'>Info recorded!<br>Rating: Good<br>Event Sequence: ".$eventSequence."<br>Location Sequence: ".$locationSequence."<br>Action Sequence: ".$actionSequence."<br></p>";
  }

  /*If 'r' parameter is bad, put passed details into bad_story table*/
  if($rating == 'b'){
    $sql = "INSERT INTO bad_story (event_sequence, location_sequence, action_sequence) VALUES('$eventSequence', '$locationSequence', '$actionSequence');";
    $handle = $conn->prepare($sql);
    $handle->execute();

    echo "<p class='text-info'>Info recorded!<br>Rating: Bad<br>Event Sequence: ".$eventSequence."<br>Location Sequence: ".$locationSequence."<br>Action Sequence: ".$actionSequence."<br></p>";
  }
}
else{
  echo "<p class='text-danger'>No info was passed!</p>";
}
 /*Call to getData() to update the user about the new state of the knowledge base*/
 echo "<script>getData();</script>";
?>
