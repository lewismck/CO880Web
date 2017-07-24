<?php
/*------------------------------------
  Main server side business logic kept
  here.
  Execute server side code and echo
  the results as JSON objects for the
  browser to manipulate and display
  Functions:
    setup
    getStory
    evaluateStory

-------------------------------------*/
//Require the classes file
require_once('classes.php');

//TODO if this require and connect are repeated - put them in a function/separate file? Maybe Main->setup();?
//Require the connect function for the database
require_once('connect.php');
$conn = connect();
// Check it
if (!$conn){
   die("Connection failed: " .  conn_connect_error());
 }

 /*parse params and get function required - Loop over params and assign them to variables. Return the function to call.*/
$main = new Main();
$params = $main->parseParams($_GET);

/*
 * Call the setup function of Main to get a KB_Data object
 * echo the data as javascript variables to use later in markovIt and makeNgrams
 */
if($params->func == 'setup'){
  $kbData = $main->setup();
  echo "Params->func: ".$params->func."<br>";

  //TODO put this all in one echo
  echo "<script> var ev_seq_kb = '".$kbData->event_seq."';</script>";
  echo "<script> var ac_seq_kb = '".$kbData->action_seq."';</script>";
  echo "<script> var loc_seq_kb = '".$kbData->location_seq."';</script>";

  $eventCount = count($kbData->event_seeds);
  $locationCount = count($kbData->location_seeds);

  echo "<label>Action Cycle Count: </label><input type=\"number\" min=\"1\" max=\"10\"  id=\"ac_cycle_count\"></input><br>";
  if($eventCount != 0){
    echo "<label>Event Seed: </label><select id='ev_seed'>";
    foreach ($kbData->event_seeds as $row) {
      echo "<option value='".$row['event_id'].",'>".$row['brief']."</option>";
    }
    echo "</select><br>";
  }
  echo "<label>Event Cycle Count: </label><input type=\"number\" min=\"1\" max=\"10\"  id=\"ev_cycle_count\"></input><br>";
  if($locationCount != 0){
    echo "<label>Location Seed: </label><select id='loc_seed'>";
    foreach ($kbData->location_seeds as $row) {
      echo "<option value='".$row['loc_id'].",'>".$row['name']."</option>";
    }
    echo "</select><br>";
  }
	echo "<label>Location Cycle Count: </label><input type=\"number\" min=\"1\" max=\"10\"  id=\"loc_cycle_count\"></input><br>
    <label>Allow Doppelgangers: </label>
  	<select name=\"no_dop\"  id=\"no_dop\">
  		<option value=\"1\" selected>True</option>
  		<option value=\"0\">False</option>
  	</select><br>
  	<label>Respect Death: </label>
  	<select name=\"respect_death\"  id=\"rd\">
  		<option value=\"1\" selected>True</option>
  		<option value=\"0\">False</option>
  	</select><br>";

}

/*------------------------------------
  Generate story parts and echo them
  Returns JSON object of all components
  with sequentially named variables
  eg. event0, event1 .. eventX
-------------------------------------*/
//TODO Have event_sequence and action_sequence and location_sequence objects storing the
//story data in comma separated lists to use in a 'NOT IN' statement to remove duplicate actions
//When storing the data in the stories table in SQL replace comma?
elseif ($params->func == 'getStory') {
  //make a StoryMaker object
  $sm = new StoryMaker();
  //make a new ReflectionCycle
  $rc = new ReflectionCycle($sm);
  echo "<script>
          var locArray = [];
          var eventArray = [];
          var actionArray = [];
        </script>";
  /*-------------------
    Generate Characters
  --------------------*/
  //first character at random
  $char1 = $sm->makeCharacter();
  //check if allow doppelgangers is set
  if($params->no_doppelgangers == 1){
    $char2 = $sm->getCharacterWhoIsnt($char1->id);
  }
  else{
    $char2 = $sm->makeCharacter();
  }
  //Display some Character Details
  echo "<h3>Characters</h3>".$char1->describe()."<br>".$char2->describe()."<br>";
  //TODO rewrite for loops (esp for location and event as a function in main/sm?)
  /*-----------------
    Generate Actions
  ------------------*/
  for ($i=0; $i < $params->ac_cycle_count; $i++) {
    echo "<h2>Action ".$i.":</h2>";
    //Create a new action
    $currentAction = $rc->actionCycleCM($char1, $char2);
    $passableAction = json_encode($currentAction);
    echo "<script>
            var action".$i." = ".$passableAction.";
            actionArray.push(".$passableAction.");
          </script>";
    //Print details
    echo $char1->firstname." ".$currentAction->brief." ".$char2->firstname.".<br>";
    echo "So ".$char1->firstname." ".$currentAction->conBrief." ".$char2->firstname.".<br>";
    echo $char1->firstname." emotional state: ".$char1->es_desc." (".$char1->emotional_state.")<br>";
    echo $char2->firstname." emotional state: ".$char2->es_desc."(".$char2->emotional_state.")<br>";

    /*Update the character arcs*/
    $char1->arc_es.=", ".$char1->emotional_state;
    $char2->arc_es.=", ".$char2->emotional_state;
    //If resepect_death is set
    if($params->respect_death == '1'){
      //Check if anyone's dead
      if ($currentAction->is_dead !== 'x') {
        if($currentAction->is_dead == 'c1'){
          $char1->kill();
        }
        else {
          $char2->kill();
        }
        echo "A character (".$currentAction->is_dead.") is Dead! Cycle stopped.";
        break;
      }
    }
  }
  /*-----------------------------------
   Return the characters to the browser
   AFTER the events have taken place
   Along with their associated 'arcs'
   ----------------------------------*/
   //JSON encode the characters for use in the browser
   $passableChar1 = json_encode($char1);
   $passableChar2 = json_encode($char2);
   echo "<script>
            var char1 = ".$passableChar1.";
            var char2 = ".$passableChar2.";
         </script>";

  /*---------------
    Generate Events
  -----------------*/
  //Turn the markov chain into an array
  $eventArray = explode(",", $params->ev_seq);
  //Quick check to see if the Markov chain is shorter then the requested number of events
  $len = count($eventArray)-1;//Remove the last empty element after the comma
  // echo $len."<br>";
  // var_dump($eventArray);
  if($len < $params->ev_cycle_count){
    echo "Short Markov chain generated!<br>";
    $limit = $len;
  }
  else{
    $limit = $params->ev_cycle_count;
  }

  //Create the required number of events echo them and return them as JSON objects
  for ($i=0; $i <= $limit-1; $i++) {
    $event_id = $eventArray[$i];

    //Error handling if there's a missing element/event is null/anything
    $exists = $sm->checkExists('event', $event_id);
    //Create a new event
    if($exists == true){
      $currentEvent = $rc->getEventByID($event_id);
    }
    //Pick a random event if there is one missing from the Markov chain
    elseif ($exists == false) {
      $currentEvent = $rc->pickRandomEvent();
    }

    //echo details
    echo "<h3>Event ".$i.":</h3>";
    echo "Event ID: ".$event_id."<br>";
    echo "Event: ".$currentEvent->brief."<br>";
    echo "Event Consequence: ".$currentEvent->conBrief."<br>";
    //return a JSON object for the browser
    $passableEvent = json_encode($currentEvent);
    echo "<script>
            var event".$i." = ".$passableEvent.";
            eventArray.push(".$passableEvent.");
          </script>";
  }

  /*------------------
    Generate Locations
  -------------------*/
  //Turn the markov chain into an array
  $locationArray = explode(",", $params->loc_seq);
  //Quick check to see if the Markov chain is shorter then the requested number of events
  $len = count($locationArray)-1;//Remove the last empty element after the comma
  // echo $len."<br>";
  // var_dump($eventArray);
  if($len < $params->loc_cycle_count){
    echo "Short Markov chain generated!<br>";
    $limit = $len;
  }
  else{
    $limit = $params->ev_cycle_count;
  }

  //Create the required number of events echo them and return them as JSON objects
  for ($i=0; $i <= $limit-1; $i++) {
    $location_id = $locationArray[$i];

    //Error handling if there's a missing element/event is null/anything
    $exists = $sm->checkExists('location', $location_id);
    //Create a new event
    if($exists == true){
      $currentLocation = $rc->getLocationByID($location_id);
    }
    //Pick a random event if there is one missing from the Markov chain
    elseif ($exists == false) {
      $currentLocation = $rc->pickRandomLocation();
    }

    //echo details
    echo "<h3>Location ".$i.":</h3>";
    echo "Location ID: ".$currentLocation->id."<br>";
    echo "Name: ".$currentLocation->name."<br>";
    echo "Description: ".$currentLocation->brief."<br>";
    //return a JSON object for the browser
    $passableLocation = json_encode($currentLocation);
    echo "<script>
            var loc".$i." = ".$passableLocation.";
            locArray.push(".$passableLocation.");
          </script>";
  }

  echo "<h3>Params:</h3>";
  foreach ($params as $key => $value) {
    echo "Key: $key Value: $value <br>";
  }
}
else{
  //echo $params->func;
  var_dump($params);
  echo "url func: ".$_GET['func']."<br>";
  echo "Params->func: ".$params->func."<br>";
}
/*Setup*/
//check if params->func = 'setup'
//if so run setup echo the JS variables
//in callback success action make ngrams of them and assign them to variables.

//Have event_sequence, location_sequence and action_sequence variables to append to as the functions run...
//return all story elements as json objects for processing by the frontend... can evaluate/process them in the success action in the AJAX request
//Function calls like get_story(cycle, eventSeq)
 ?>
