<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<!-- bootstrap for styling -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <!-- Bootstrap and jquery js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
  <!-- Project specific JS - Makes calls to different PHP scripts which in turn call functions in this file -->
	<script src="../js/MarkovTesting.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test Action and Character</title>
</head>
<body onload="makeNgrams('56666535555656665663555996536665', 1);">
  <button onclick="markovIt(5, makeNgrams(dataSet, 1), 1, cycleCount);">Markov</button>
	<p id="resultBox"></p>
  <button onclick="eventCycle(markovIt(5, makeNgrams(dataSet, 1), 1, cycleCount), cycleCount);">Event Cycle</button>
  <div id="test1"></div>
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
//Make a setup() function that will get the story data and assign it to JS (JSON) variables
//Can call markovIt() based on the number of cycles specified to get a list of events/actions/locations, then select them in a loop returning the objects for each one.
$testSet = "56666535555656665663555996536665";

//make a StoryMaker object
$sm = new StoryMaker();
//make a new ReflectionCycle
$rc = new ReflectionCycle($sm);
//Get the event sequence data in a list that makeNgrams can process
$eventSeqQuery = "SELECT GROUP_CONCAT(TRIM(event_sequence) SEPARATOR '') event_seq FROM good_story;";
$eventData = executeQuery($eventSeqQuery);
//pass the data to makeNgrams
//var_dump($eventData);

// foreach ($eventData as $eventRow) {
//   echo "<br>".$eventRow['event_seq'];
// }
//echo $eventData;
echo "<script>makeNgrams('".$eventData[0]['event_seq']."', 1);</script>";
echo "<script>var dataSet = '".$eventData[0]['event_seq']."';</script>";
echo "<script>var cycleCount = '".$_GET['cycleCount']."';</script>";
//Get a markov chain of events from MarkovIt function
//Pass that chain to a loop for processing

//Make 2 characters
$char1 = $sm->makeCharacter();
echo $char1->describe();
echo "<br>";
$char2 = $sm->getCharacterWhoIsnt($char1->id);
echo $char2->describe();


if(isset($_GET['cycleCount'])){
  for ($i=0; $i < $_GET['cycleCount']; $i++) {
    echo "<h2>Action ".$i.":</h2>";
    //Create a new action
    $currentAction = $rc->actionCycleCM($char1, $char2);
    //Create a new event
    //$currentEvent = $rc->randomEventCycle();
    //Update the emotional states of the characters
    // $char1->emotional_state = $char1->emotional_state + $currentAction->c1_es;
    // $char1->es_desc = $currentAction->c1_es_desc;
    // $char2->emotional_state = $char2->emotional_state + $currentAction->c2_es;
    // $char2->es_desc = $currentAction->c2_es_desc;

    //Print details
    echo $char1->firstname." ".$currentAction->brief." ".$char2->firstname.".<br>";
    echo "So ".$char1->firstname." ".$currentAction->conBrief." ".$char2->firstname.".<br>";
    echo $char1->firstname." emotional state: ".$char1->es_desc." (".$char1->emotional_state.")<br>";
    echo $char2->firstname." emotional state: ".$char2->es_desc."(".$char2->emotional_state.")<br>";

    //Check if anyone's dead
    if ($currentAction->is_dead !== 'x') {
      if($currentAction->is_dead == 'c1'){
        $char1->isAlive = false;
      }
      else {
        $char2->kill();
      }
      echo "A character (".$currentAction->is_dead.") is Dead! Cycle stopped.";
      break;
    }
  }
}
//choose another action to improve unhappy characters mood
?>
</body>
</html>
