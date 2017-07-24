<?php
/*
 * Choose actions in a story based on character's motivations
 */
//Require the classes file
require_once('classes.php');

//Require the connect function for the database
require_once('connect.php');
$conn = connect();
// Check it
if (!$conn){
   die("Connection failed: " .  conn_connect_error());
 }
//make a StoryMaker object
$sm = new StoryMaker();
//make a new ReflectionCycle
$rc = new ReflectionCycle($sm);
//Check the parameters are set
if(isset($_GET['cycleCount']) && isset($_GET['seq'])){
  $eventSeq = $_GET['seq'];
  $len = strlen($_GET['seq']);
  if($len < $_GET['cycleCount']){
    echo "Short Markov chain generated!<br>";
    $limit = $len;
  }
  else{
    $limit = $_GET['cycleCount'];
  }
  for ($i=0; $i < $limit; $i++) {
    $event_id = $eventSeq[$i];
    //Error handling if there's a missing element/event is null/anything
    echo "<h2>Event ".$i.":</h2>";
    //Create a new event
    $currentEvent = $rc->getEventByID($event_id);
    echo "Event ID: ".$event_id."<br>";
    echo "Event: ".$currentEvent->brief."<br>";
    echo "Event Consequence: ".$currentEvent->conBrief."<br>";

  }
}
?>
