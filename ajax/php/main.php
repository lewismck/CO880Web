<?php
/**
 * @author Lewis Mckeown
 **/
/*------------------------------------
  Main server side business logic kept
  here.
  Execute server side code and echoes
  the results as JSON objects for the
  browser to manipulate and display.
  Functions:
    setup
    getStory
    evaluateStory
    getChartData

-------------------------------------*/
//Require the classes file
require_once('classes.php');

//TODO if this require and connect are repeated - put them in a function/separate file?
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
//make a StoryMaker object
$sm = new StoryMaker();
//make a new ReflectionCycle
$rc = new ReflectionCycle($sm);

/*-----------------------------------------------------------
 * Call the setup function of Main to get a KB_Data object
 * echo the data as javascript variables to use
 * later in buildMarkov and makeNgrams
 ----------------------------------------------------------*/
if($params->func == 'setup'){
  $kbData = $main->setup();

  //Echo the data from the knowledge base that the n-gram and markov functions need
  echo "<script>
          var ev_seq_kb = '".$kbData->event_seq."';
          var ac_seq_kb = '".$kbData->action_seq."';
          var loc_seq_kb = '".$kbData->location_seq."';
        </script>";

  //Random event seed:
  $randomEvent = $rc->pickRandomEvent();
  if(strlen($randomEvent->id) >= 2){
    $randomEventSeed = $randomEvent->id;
  }
  else{
    $randomEventSeed = $randomEvent->id.","; //echo as JS variable so it can be updated each time a story is generated?
  }
  //Random location seed:
  $randomLocation = $rc->pickRandomLocation();
  if(strlen($randomLocation->id) >= 2){
    $randomLocationSeed = $randomLocation->id;
  }
  else{
    $randomLocationSeed = $randomLocation->id.",";
  }
  //Random action seed:
  $randomAction = $rc->pickRandomAction();
  if(strlen($randomAction->id) >= 2){
    $randomActionSeed = $randomAction->id;
  }
  else{
    $randomActionSeed = $randomAction->id.",";
  }

  $eventCount = count($kbData->event_seeds);
  $locationCount = count($kbData->location_seeds);
  $actionCount = count($kbData->action_seeds);

  /*-------------------
       Cycle Count
  --------------------*/
  echo "<label>Cycle Count: </label><select id=\"cycle_count\">
          <option value=\"1\" >1</option>";
  for ($i = 2; $i <= 10; $i++) {
    if($i == 3){
        echo "<option value='".$i."' selected>".$i."</option>";
    }
    else{
      echo "<option value='".$i."'>".$i."</option>";
    }
  }
  echo "</select><br>";
  /*-------------------
       Action Seed
  --------------------*/
  if($actionCount != 0){
    echo "<label>Action Seed: </label><select id='ac_seed' disabled=\"true\">
          <option value='".$randomActionSeed."' selected>Random</option>";
    foreach ($kbData->action_seeds as $row) {
      if(strlen($row['ac_id']) >= 2){
        $currentActionSeed = $row['ac_id'];
      }
      else{
        $currentActionSeed = $row['ac_id'].",";
      }
      //Setup some data for the action frequency chart
      echo "<option value='".$currentActionSeed."'>".$row['brief']."</option>";
    }
    echo "</select><br>";
  }
  /*-------------------
        Event Seed
  --------------------*/
  if($eventCount != 0){
    echo "<label>Event Seed: </label><select id='ev_seed'>
          <option value='".$randomEventSeed."' selected>Random</option>";
    foreach ($kbData->event_seeds as $row) {
      if(strlen($row['event_id']) >= 2){
        $currentEventSeed = $row['event_id'];
      }
      else{
        $currentEventSeed = $row['event_id'].",";
      }
      //Setup some data for the action frequency chart
      echo "<option value='".$currentEventSeed."'>".$row['brief']."</option>";
    }
    echo "</select><br>";
  }

  /*-------------------
      Location Seed
  --------------------*/
  if($locationCount != 0){
    echo "<label>Location Seed: </label><select id='loc_seed'>
          <option value='".$randomLocationSeed."' selected>Random</option>";
    foreach ($kbData->location_seeds as $row) {
      if(strlen($row['loc_id']) >= 2){
        $currentLocSeed = $row['loc_id'];
      }
      else{
        $currentLocSeed = $row['loc_id'].",";
      }
      //Setup some data for the action frequency chart
      echo "<option value='".$row['loc_id'].",'>".$row['name']."</option>";
    }
    echo "</select><br>";
  }
  /*--------------------------------------------------------
      Static params (now just plain HTML in generator.php)
  ---------------------------------------------------------*/

}

/*------------------------------------
  Generate story parts and echo them
  Returns JSON object of all components
  with sequentially named variables
  eg. event0, event1 .. eventX
-------------------------------------*/
elseif ($params->func == 'getStory') {
  //Initialise some javascript arrays for storing the stor details as they occur
  //all output is placed in a #storyBox div when returned to the browser (viewable in a modal popup)
  echo "<script>
          var locArray = [];
          var eventArray = [];
          var actionArray = [];
        </script>";

  //Set some useful variables and create a Story
  $early_break = 0; //Used for breaking from the event/location cycles if a character has died and respect_death is on
  $story = new Story();
  //Set the known story variables and a temporary rating
  $story->rating = 'x'; //currently unrated
  $story->respect_death = $params->respect_death;
  $story->allow_doppelgangers = $params->allow_doppelgangers;
  //Set story metadata based on action choice
  $story->action_choice = $params->action_choice;
  $story->location_choice = $params->location_choice;
  $story->event_choice = $params->event_choice;

  /*-------------------
    Generate Characters
  --------------------*/
  //first character at random
  $char1 = $sm->makeCharacter();
  //check if allow doppelgangers is set
  if($params->allow_doppelgangers == 1){
    $char2 = $sm->makeCharacter();
  }
  else{
    $char2 = $sm->getCharacterWhoIsnt($char1->id);
  }
  //Display some Character Details
  echo "<h3>Characters</h3>".$char1->describe()."<br>".$char2->describe()."<br>";

  //TODO rewrite for loops (esp for location and event as a function in main/sm?)
  /*-----------------
    Generate Actions
  ------------------*/
  //Turn the markov chain into an array
  if($params->action_choice == 'markov'){
    $actionArray = explode(",", $params->ac_seq);
  }
  //Create the required number of actions
  for ($i=0; $i < $params->cycle_count; $i++) {
    echo "<h2>Action ".$i.":</h2>";
    //Create a new action
    if($params->action_choice == 'cm'){
      $currentAction = $rc->actionCycleCM($char1, $char2);
    }
    elseif ($params->action_choice == 'markov') {
      $action_id = $actionArray[$i];
      //Error handling if there's a missing element/event is null/etc
      $exists = $sm->checkExists('action', $action_id);
      //Create a new event
      if($exists == true){
        $currentAction = $rc->getActionByID($action_id, $char1, $char2);
      }
      //Pick a random event if there is one missing from the Markov chain
      elseif ($exists == false) {
        $currentAction = $rc->actionCycleRandom($char1, $char2);
      }
    }
    else { //action choice must be random
      $currentAction = $rc->actionCycleRandom($char1, $char2);
    }

    $passableAction = json_encode($currentAction);
    //Update the action_sequence
    $story->updateActionSeq($currentAction->id);
    echo "<script>
            var action".$i." = ".$passableAction.";
            actionArray.push(".$passableAction.");
          </script>";
    //Print details
    echo "ID: ".$currentAction->id."<br>Brief: ".$currentAction->brief.".<br>"
    ."consequence Brief: ".$currentAction->conBrief.".<br>"
    .$char1->firstname." emotional state: ".$char1->es_desc." (".$char1->emotional_state.")<br>"
    .$char2->firstname." emotional state: ".$char2->es_desc."(".$char2->emotional_state.")<br>";


    //Check if anyone's dead
    if ($currentAction->is_dead !== 'x') {
        if($currentAction->is_dead == 'c1'){
          $char1->kill();
        }
        if($currentAction->is_dead == 'c2') {
          $char2->kill();
        }
        //If resepect_death is set - check if anyone has died
        if($params->respect_death == '1'){
            echo "A character (".$currentAction->is_dead.") is Dead! Cycle stopped.";
            $early_break = $i+1; //set +1 as the other loops subtract 1 from limit
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
  if($params->event_choice == 'markov'){
    //Turn the markov chain into an array
    $eventArray = explode(",", $params->ev_seq);
    //Quick check to see if the Markov chain is shorter then the requested number of events OR the action cycle ended early because of respect_death
    $len = count($eventArray);//Remove the last empty element after the comma
    if($len < $params->cycle_count){
      echo "Short Markov chain generated!<br>";
      $limit = $len;
    }
  }
  if($early_break != 0){
    $limit = $early_break;
  }
  else{
    $limit = $params->cycle_count;
  }

  //Create the required number of events echo them and return them as JSON objects
  for ($i=0; $i <= $limit-1; $i++) {
    if($params->event_choice == 'markov'){
      $event_id = $eventArray[$i];
      //Error handling if there's a missing element/event is null/etc
      $exists = $sm->checkExists('event', $event_id);
      //Create a new event
      if($exists == true){
        $currentEvent = $rc->getEventByID($event_id);
      }
      //Pick a random event if there is one missing from the Markov chain
      if ($exists == false) {
        $currentEvent = $rc->pickRandomEvent();
      }
    }
    else{ //choice must be random
      $currentEvent = $rc->pickRandomEvent();
    }

    //echo details
    echo "<h3>Event ".$i.":</h3>";
    echo "Event ID: ".$currentEvent->id."<br>";
    echo "Event: ".$currentEvent->brief."<br>";
    echo "Event Consequence: ".$currentEvent->conBrief."<br>";
    //return a JSON object for the browser
    $passableEvent = json_encode($currentEvent);
    //Update the event_sequence
    $story->updateEventSeq($currentEvent->id);
    echo "<script>
            var event".$i." = ".$passableEvent.";
            eventArray.push(".$passableEvent.");
          </script>";
  }

  /*------------------
    Generate Locations
  -------------------*/
  if($params->location_choice == 'markov'){
    //Turn the markov chain into an array
    $locationArray = explode(",", $params->loc_seq);
    //Quick check to see if the Markov chain is shorter then the requested number of events OR the action cycle ended early because of respect_death
    $len = count($locationArray);//Remove the last empty element after the comma
    if($len < $params->cycle_count){
      echo "Short Markov chain generated!<br>";
      $limit = $len;
    }
  }
  if($early_break != 0){
    $limit = $early_break;
  }
  else{
    $limit = $params->cycle_count;
  }

  //Create the required number of locations echo them and return them as JSON objects
  for ($i=0; $i <= $limit-1; $i++) {
    if($params->location_choice == 'markov'){
      $location_id = $locationArray[$i];
      //Error handling if there's a missing element/location is null/etc
      $exists = $sm->checkExists('location', $location_id);
      //Create a new event
      if($exists == true){
        $currentLocation = $rc->getLocationByID($location_id);
      }
      //Pick a random event if there is one missing from the Markov chain
      elseif ($exists == false) {
        $currentLocation = $rc->pickRandomLocation();
      }
    }
    else{ //must be set to random
      $currentLocation = $rc->pickRandomLocation();
    }

    //echo details
    echo "<h3>Location ".$i.":</h3>";
    echo "Location ID: ".$currentLocation->id."<br>";
    echo "Name: ".$currentLocation->name."<br>";
    echo "Description: ".$currentLocation->brief."<br>";
    //return a JSON object for the browser
    $passableLocation = json_encode($currentLocation);
    //Update the location_sequence
    $story->updateLocationSeq($currentLocation->id);
    echo "<script>
            var loc".$i." = ".$passableLocation.";
            locArray.push(".$passableLocation.");
          </script>";
  }

  /*------------------------
    Save and echo Story
   -----------------------*/
   //Save the story to the KB
   $result = $story->saveStory();
   //Save the characters
   $story->saveCharacter($char1);
   $story->saveCharacter($char2);
   $passableStory = json_encode($story);
   echo "<script>
          var story = ".$passableStory.";
         </script>";
    //Return the parsed params to the DOM
    $main->echoParams($params);
    //Show the Levenshtein Distances for each component
    echo "<h3>Levenshtein Distances for each section</h3>";
    echo "Location Lev: ".$main->getLevenshteinDistance($story->location_sequence, 'location', 'g')."<br>";
    echo "Action Lev: ".$main->getLevenshteinDistance($story->action_sequence, 'action', 'g')."<br>";
    echo "Event Lev: ".$main->getLevenshteinDistance($story->event_sequence, 'event', 'g')."<br>";
}

/*----------------------------------
  Save the story rating to the KB
 ----------------------------------*/
elseif ($params->func == 'evaluateStory') {
  //Update the story's rating
  $result = $main->rateLatestStory($params->rating);
  $latestID = $main->getLatestStoryID();
  $main->echoParams($params); //Return the parsed params to the browser DOM

  //Check the result and return it with user facing feedback.
  if($result == true){
    //also pushes the latest rating for getting the data into the story log, for evaluation of the stories by users.
    //Must be kept in sync with the generate button presses.
    echo "<script>
            $('#evaluateBox').html('Story evaluated as ".$params->rating_hr.".');
            story_id_list.push(".$latestID.");
          </script><br>Result: ".$result;
  }
  else{
    echo "<script>
            $('#evaluateBox').html('Something went wrong. Check Params?');
          </script><br>Result: ".$result;
  }
}
/*----------------------------------
  Get the data for the charts
 ----------------------------------*/
elseif($params->func == 'getChartData'){
  $kbData = $main->setup();

  /*Get some story data and echo is to turn into charts*/
  $goodStoryData = $main->getStoryData('g');
  $passableGSD = json_encode($goodStoryData);
  $badStoryData = $main->getStoryData('b');
  $passableBSD = json_encode($badStoryData);
  $passableSortedBadActions = json_encode($main->turnKBDataToArray($kbData->action_seq_b));
  $passableSortedActions = json_encode($main->turnKBDataToArray($kbData->action_seq));
  $passableSortedBadEvents = json_encode($main->turnKBDataToArray($kbData->event_seq_b));
  $passableSortedEvents = json_encode($main->turnKBDataToArray($kbData->event_seq));
  $passableSortedBadLocations = json_encode($main->turnKBDataToArray($kbData->location_seq_b));
  $passableSortedLocations = json_encode($main->turnKBDataToArray($kbData->location_seq));
  $passableAVGcreativity = json_encode($main->getCreativityRatings());
  $passableLikeDislike = json_encode($main->getLikeToDislike());
  //Echo the data from the knowledge base that the n-gram and markov functions need
  //This will be re-thought when I redo the charts module - the event/loc/action frequencies aren't used at all anymore
  echo "<script>
          var sortedBadActions = ".$passableSortedBadActions.";
          var sortedActions = ".$passableSortedActions.";
          var sortedBadEvents = ".$passableSortedBadEvents.";
          var sortedEvents = ".$passableSortedEvents.";
          var sortedBadLocations = ".$passableSortedBadLocations.";
          var sortedLocations = ".$passableSortedLocations.";
          var avgCreativity = ".$passableAVGcreativity.";
          var likeToDislike = ".$passableLikeDislike.";
          var ac_labels = [];
          var ac_values = [];
          var ev_labels = [];
          var ev_values = [];
          var loc_labels = [];
          var loc_values = [];
          var gsd = ".$passableGSD.";
          var bsd = ".$passableBSD.";
        </script>";
}
/*---------------------------------------------------
  If no recognised function passed, just dump params
 ---------------------------------------------------*/
else{
  //echo $params->func;
  $main->echoParams($params); //Return the parsed params to the browser DOM
}
 ?>
