<?php
/*
 * Generates a short story from randomly chosen components (RAND() in MySQL) and print the outline
 * Creates objects of each story component -turned to JSON objects to be passed to the showDetails() JS function
 * Returns the story and a list of it's components.
 * Checks if story component sequence exists, if not a dupe then gives buttons to evaluate the story as good or bad
 * (If story is a duplicate it still prints it - rather than generating a new one, written this way for testing)
 * Creates a StoryMaker object, to create story components and to get data about the event/location
 * /action sequences frequency in the knowledge base
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

/*Create a div to put the story outline --closed when story outline printed*/
echo "<div id='outlineBox'></div>
      <h4>Components</h4>";
if(isset($_GET['charcount'])){
  $charLimit = $_GET['charcount'];
  $characterStatement = "SELECT s_character.*, character_desc.age, character_desc.temperment FROM s_character
                        JOIN character_desc ON s_character.c_desc=character_desc.desc_id
                        ORDER BY RAND() LIMIT $charLimit;";
}

else{
  $characterStatement = "SELECT s_character.*, character_desc.age, character_desc.temperment FROM s_character
                        JOIN character_desc ON s_character.c_desc=character_desc.desc_id
                        ORDER BY RAND() LIMIT 2;";
}

  $locationStatement = "SELECT * FROM location ORDER BY RAND() LIMIT 1;";
  $actionStatement = "SELECT action.*, action_consequence.brief AS con_brief, action_consequence.long_desc AS con_long, action_consequence.tone AS con_tone
                      FROM action
                      JOIN action_consequence ON action.consequence=action_consequence.con_id
                      ORDER BY RAND() LIMIT 1;";
  $eventStatement = "SELECT event.*, event_consequence.brief AS con_brief, event_consequence.long_desc AS con_long, event_consequence.tone AS con_tone
                     FROM event
                     JOIN event_consequence ON event.consequence=event_consequence.con_id
                     ORDER BY RAND() LIMIT 1;";

  /*execute CHARACTER statement*/
  $resultC = executeQuery($characterStatement);
  $sizeC = count($resultC);

  /*
   * Creating characters without magic numbers (unlike the actions and events below)
   * Trade off is executing the code immediately -not by calling a function- and
   * printing everything as it's executed.
   */
  if($sizeC != 0){
    $characterfName1 = $resultC[0]['fName'];
    $characterlName1 = $resultC[0]['lName'];
    //Character 2 details
    $characterfName2 = $resultC[1]['fName'];
    $characterlName2 = $resultC[1]['lName'];
    $i = 1; //For variable naming
    $charIdentifier = "\"c\""; //for easy passing to javascript function

    foreach ($resultC as $rowC) {
      //Create a person object for each selected character with a person1...X naming scheme
      ${'person'.$i} = new Person($rowC['c_id'], $rowC['fName'], $rowC['lName'], $rowC['gender'], $rowC['c_desc'], $rowC['age'], $rowC['temperment']);
      //echo ${'person'.$i}->describe();

      /*Turn the Person object into a JSON array to give to a javascript function*/
      $passablePerson = json_encode(${'person'.$i});

      echo "<a class='text-info' onclick='showDetails(".$passablePerson.",".$i.",".$charIdentifier.");' style='cursor: pointer;'>".${'person'.$i}->firstname." ".${'person'.$i}->lastname."</a><br>
            <div id='characterInfo".$i."'></div>";
      $i++;
    }
  }

  /*create the location object and print it and it's details to the page*/
  $location1 = $sm->getLocation($locationStatement);
  $locationName = $location1->name;
  $locIdentifier = "\"l\"";
  $locationSequence = "";
  $locationSequence += $location1->id." ";
  $passableLoc = json_encode($location1);

  echo "<a class='text-success' onclick='showDetails(".$passableLoc.",1,".$locIdentifier.");' style='cursor: pointer;'>".$locationName."</a><br>
        <div id='locationInfo1'></div>";

  /*create the action object and print it and it's details*/
  $action1 = $sm->getAction($actionStatement); //magic number naming solution is non-optimal, but works for current example
  $actionBrief = $action1->brief;
  $actionCon = $action1->conBrief;
  $actionIdentifier = "\"a\"";
  $actionSequence = "";
  $actionSequence.=$action1->id." ";
  /*Turn the Action object into a JSON array to give to a javascript function*/
  $passableAction = json_encode($action1);

  echo "<a class='text-warning' onclick='showDetails(".$passableAction.",1,".$actionIdentifier.");' style='cursor: pointer;'>".$actionBrief."</a><br>
        <div id='actionInfo1'></div>";

  /*create the event object and print it and it's details*/
  $event1 = $sm->getEvent($eventStatement);
  $eventBrief = $event1->brief;
  $eventCon = $event1->conBrief;
  $eventIdentifier = "\"e\""; //for easy passing to javascript function
  $eventSequence = "";
  $eventSequence.=$event1->id." ";
  /*Turn the event object into a JSON array to give to a javascript function*/
  $passableEvent = json_encode($event1);

  echo "<a class='text-danger' onclick='showDetails(".$passableEvent.",1,".$eventIdentifier.");' style='cursor: pointer;'>".$eventBrief."</a><br>
        <div id='eventInfo1'></div>";

  /*String of story events put together, highlihgted with story fragment colours*/
  $storyHighlighted = "<span class='text-danger'>".$eventBrief."</span> meanwhile <span class='text-info'>".$characterfName1." ".$characterlName1." </span><span class='text-warning'>".$actionBrief."</span><span class='text-info'> ".$characterfName2." ".$characterlName2. "</span> at <span class='text-success'>".$locationName.
  "</span>. <span class='text-info'>".$characterfName1." </span><span class='text-warning'>".$actionCon."</span> <span class='text-info'>".$characterfName2."</span> as <span class='text-danger'>".$eventCon."</span><br>";

  /*String of story events put together with no highlighting*/
  $storyPlain = $eventBrief." meanwhile ".$characterfName1." ".$characterlName1." ".$actionBrief." ".$characterfName2." ".$characterlName2. " at ".$locationName.
  ". ".$characterfName1." ".$actionCon." ".$characterfName2." as ".$eventCon."<br>";

  /*Check for duplicated story - don't display buttons if it's a dupe*/
  $duplicateStatement = "SELECT * FROM good_story WHERE event_sequence='$eventSequence' AND location_sequence='$locationSequence' AND action_sequence='$actionSequence';";
  $dupeResults = executeQuery($duplicateStatement);
  $duplicate = count($dupeResults);

  /*If not a duplicate print the story with stats and evaluate buttons*/
  if($duplicate == 0){
    //Show the story
    echo "<script>printOutline(\"".$storyHighlighted."\", 0);</script>";
    echo "<h4>Stats:</h4>";
    //Show the story data
     $stats = $sm->getStoryStatistics($eventSequence, $locationSequence, $actionSequence);
     echo "<p>Event sequence frequency: ".$stats["eventFreq"]."/".$stats["kbSize"]." Or ".$stats["eventPer"]."%</p>";
     echo "<p>Location sequence frequency: ".$stats["locFreq"]."/".$stats["kbSize"]." Or ".$stats["locPer"]."%</p>";
     echo "<p>Action sequence frequency: ".$stats["acFreq"]."/".$stats["kbSize"]." Or ".$stats["acPer"]."%</p>";
    //button(s) to evaluate the story
    echo "<div id='evaluateBox'><a class='btn btn-success' onclick='evaluateStory(".$eventSequence.",".$locationSequence.", ".$actionSequence.", \"g\");' style='cursor: pointer;'>Good</a> <a class='btn btn-danger' onclick='evaluateStory(".$eventSequence.",".$locationSequence.", ".$actionSequence.", \"b\");' style='cursor: pointer;'>Bad</a> </div>";

  }
  /*If a duplicate story then print without stats and evaluate buttons*/
  else{
    //print the story with duplicate flag set to 1
    echo "<script>printOutline(\"".$storyPlain."\", 1);</script>";
  }

?>
