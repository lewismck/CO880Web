<?php
/*--------------------------------------------------------------------------------------
 Classes for the main story components: Person, Location, Action, Event (and their consequences -- now deprecated)
 Also contains a StoryMaker class with functions for creating and returning the story components and a ReflectionCycle class for generating actions/events/locations in loops
 ---------------------------------------------------------------------------------------*/

require_once('queries.php'); //Require the queries.php file - contains all the SQL code used

class Main {

  /**
   * @return a KB_Data object with it's attributes completed
   * Query all the story data from the KB and set it as javascript variables
   **/
  public function setup(){

    //Use the global queries from queries.php
    global $KBQuery, $eventSeedGet, $locationSeedGet, $actionSeedGet;


    $KBData = executeQuery($KBQuery);
    //Good story data
    $event_seq = $KBData[0]['event_seq'];
    $action_seq = $KBData[0]['action_seq'];
    $location_seq = $KBData[0]['location_seq'];
    //Bad story data
    $event_seq_b = $KBData[1]['event_seq'];
    $action_seq_b = $KBData[1]['action_seq'];
    $location_seq_b = $KBData[1]['location_seq'];
    //Seeds
    $event_seeds = executeQuery($eventSeedGet);
    $location_seeds = executeQuery($locationSeedGet);
    $action_seeds = executeQuery($actionSeedGet);
    //return a KB_Data object
    $kbData = new KB_Data($action_seq, $event_seq, $location_seq, $event_seeds, $location_seeds, $action_seeds, $action_seq_b, $event_seq_b, $location_seq_b);
    return $kbData;
  }

  /**
   * @param a single letter (g/b) indicating if good or bad story data is requested
   * @return an array containing good story constraint counts
   * Used for putting data into a Radar and doughnut charts
   **/
  public function getStoryData($goodOrBad){
    //Use the global queries from queries.php
    global $goodStoryChart, $badStoryChart;

    //Choose good or bad story data to return
    if($goodOrBad == 'g'){
      $storyQuery = executeQuery($goodStoryChart);
    }
    else{
      $storyQuery = executeQuery($badStoryChart);
    }

    //construct a StoryData object and return it.
    $storyData = new StoryData($storyQuery[0]['story_data'], $storyQuery[1]['story_data'], $storyQuery[2]['story_data'], $storyQuery[3]['story_data'], $storyQuery[4]['story_data'],
    $storyQuery[5]['story_data'], $storyQuery[6]['story_data'], $storyQuery[7]['story_data']
    ,$storyQuery[8]['story_data']
    ,$storyQuery[9]['story_data']
    ,$storyQuery[10]['story_data']);

    return $storyData;
  }

  /**
   * Get the creativity ratings
   * @return the average creativity ratings for each dataset as an array
   **/
  function getCreativityRatings(){
    global $avgCreativityRatings;
    $cr = executeQuery($avgCreativityRatings);

    $creativityRatings = array();
    foreach ($cr as $row) {
      array_push($creativityRatings, $row['AVG(creativity_rating)']);
    }
    //
    // array_push($creativityRatings, $cr[1]['AVG(creativity_rating)']);
    // array_push($creativityRatings, $cr[2]['AVG(creativity_rating)']);
    // array_push($creativityRatings, $cr[3]['AVG(creativity_rating)']);

    return $creativityRatings;
  }

  /**
   * Get the Unliked/Likes for each dataset
   * @return the dislikes and likes for each dataset as an array
   **/
  function getLikeToDislike(){
    global $getLikeAndDislike;
    $dl = executeQuery($getLikeAndDislike);

    $likeAndDislike = array();
    foreach ($dl as $row) {
      array_push($likeAndDislike, $row['likeOrDislike']);
    }
    //
    // array_push($likeAndDislike, $cr[1]['AVG(creativity_rating)']);
    // array_push($likeAndDislike, $cr[2]['AVG(creativity_rating)']);
    // array_push($likeAndDislike, $cr[3]['AVG(creativity_rating)']);

    return $likeAndDislike;
  }

  /**
   * @param a string containing a comma separated, list of values
   * @return an array list of the values with their frequency in key-value pairs
   * Turn a string from the KB into a list containing key-value pairs
   * of items and their frequency
   **/
  public function turnKBDataToArray($kbData){
    $kbToArray = explode(",", $kbData);
    $sortedArray = array_count_values($kbToArray);
    return $sortedArray;
  }
  /**
   * @param array (_GET/_POST) containing parameters to be parsed.
   * @return a ParsedParams object with the fields in $params filled
   * in
   * TODO sanitise inputs
   **/
  public function parseParams($params){
    $parsedParams = new ParsedParams();
    foreach($params as $key => $value){
      if($key == 'func'){
        $parsedParams->func = $value;
      }
      elseif($key == 'cycle_count'){
        $parsedParams->cycle_count = $value;
      }
      elseif($key == 'ev_cycle_count'){
        $parsedParams->ev_cycle_count = $value;
      }
      elseif($key == 'ac_cycle_count'){
        $parsedParams->ac_cycle_count = $value;
      }
      elseif($key == 'loc_cycle_count'){
        $parsedParams->loc_cycle_count = $value;
      }
      elseif($key == 'ac_seq'){
        $parsedParams->ac_seq = $value;
      }
      elseif($key == 'ev_seq'){
        $parsedParams->ev_seq = $value;
      }
      elseif($key == 'loc_seq'){
        $parsedParams->loc_seq = $value;
      }
      elseif($key == 'action_choice'){
        $parsedParams->action_choice = $value;
      }
      elseif($key == 'event_choice'){
        $parsedParams->event_choice = $value;
      }
      elseif($key == 'location_choice'){
        $parsedParams->location_choice = $value;
      }
      elseif($key == 'cm'){
        $parsedParams->character_motive = $value;
      }
      elseif($key == 'markov_action'){
        $parsedParams->markov_action = $value;
      }
      elseif($key == 'random_action'){
        $parsedParams->random_action = $value;
      }
      elseif($key == 'no_dop'){
        $parsedParams->allow_doppelgangers = $value;
      }
      elseif($key == 'rd'){
        $parsedParams->respect_death = $value;
      }
      elseif($key == 'rating'){
        $parsedParams->rating = $value;
      }
      elseif($key == 'rating_hr'){
        $parsedParams->rating_hr = $value;
      }
    }
    return $parsedParams;
  }

  /**
   * @param the params object (or any key value array really)
   * @return echoes the key value pairs of $params
   **/
  function echoParams($params){
    echo "<h3>Params:</h3>";
    foreach ($params as $key => $value) {
      echo "Key: $key Value: $value <br>";
    }
  }

  /**
   * @param the rating 'g'/'b' of the story
   * @return true if the evaluated_story row was updated succesfully
   * else false
   **/
  public function rateLatestStory($rating){
    global $updateStoryRating;
    $latest_id = $this->getLatestStoryID();

    $updateStoryStatement = $updateStoryRating." '".$rating."' WHERE es.story_id =".$latest_id;
    $result = executeInsert($updateStoryStatement);
    return $result;
  }

  /**
   * Query and return the latest story id
   * @return the latest story's story_id
   **/
  public function getLatestStoryID(){
    global $getLatestStoryIDQuery;
    $latest_id_request = executeQuery($getLatestStoryIDQuery);
    $latest_id = $latest_id_request[0]['story_id'];
    return $latest_id;
  }
}

/*
 * Class to store some data used for building charts
 */
class StoryData {
  /*
   * Good story pie
   * random event
   * markov event
   * random location
   * markov location
   * random action
   * markov action
   * cm action
   * don't allow doppelgangers
   * allow doppelgangers
   * don't respect death
   * respect death
   */
   public $random_event;
   public $markov_event;
   public $random_location;
   public $markov_location;
   public $random_action;
   public $markov_action;
   public $cm_action;
   public $no_doppelgangers;
   public $allow_doppelgangers;
   public $ignore_death;
   public $respect_death;

   //constructor
   public function __construct($random_event, $markov_event, $random_location, $markov_location, $random_action, $markov_action, $cm_action, $no_doppelgangers,$allow_doppelgangers,$ignore_death,$respect_death ){
     $this->random_event = $random_event;
     $this->markov_event = $markov_event;
     $this->random_location = $random_location;
     $this->markov_location = $markov_location;
     $this->random_action = $random_action;
     $this->markov_action = $markov_action;
     $this->cm_action = $cm_action;
     $this->no_doppelgangers = $no_doppelgangers;
     $this->allow_doppelgangers = $allow_doppelgangers;
     $this->ignore_death = $ignore_death;
     $this->respect_death = $respect_death;
   }
  //echo "<script>var re = ".$goodStoryData[0]['story_data'].";</script>";
}

/*
 * Class for holding data from the knowledge base
 * It's values can be returned to the browser as JSON objects
 * for use with the JS markov and ngram functions
 */
class KB_Data {
  public $action_seq;
  public $event_seq;
  public $location_seq;
  public $action_seq_b;
  public $event_seq_b;
  public $location_seq_b;
  public $event_seeds;
  public $location_seeds;
  public $action_seeds;

  //constructor
  public function __construct($action_seq, $event_seq, $location_seq, $event_seeds, $location_seeds, $action_seeds,$action_seq_b, $event_seq_b, $location_seq_b){
    $this->action_seq = $action_seq;
    $this->event_seq = $event_seq;
    $this->location_seq = $location_seq;
    $this->event_seeds = $event_seeds;
    $this->location_seeds = $location_seeds;
    $this->action_seeds = $action_seeds;
    $this->action_seq_b = $action_seq_b;
    $this->event_seq_b = $event_seq_b;
    $this->location_seq_b = $location_seq_b;
  }
}

/*
 * An object containing the useful params
 */
class ParsedParams {
  public $func;
  public $ev_cycle_count;
  public $ac_cycle_count;
  public $loc_cycle_count;
  public $cycle_count;
  public $ac_seq;
  public $ev_seq;
  public $loc_seq;
  public $action_choice;
  public $event_choice;
  public $location_choice;
  public $character_motive;
  public $markov_action;
  public $random_action;
  public $allow_doppelgangers;
  public $respect_death;
  public $rating;
  public $rating_hr; //Human readable rating
}

/*
 * Class for characters, contains character data and 'arcs'
 * Functions to 'kill' and update characters
 */
class Person {
  public $isAlive = true;
  public $id;
  public $firstname;
  public $lastname;
  public $gender;
  public $descID;
  public $age;
  public $temperment;
  public $emotional_state = 0;
  public $es_desc = 'neutral';
  public $arc_es = '0';
  public $arc_desc = 'neutral';

  // Assigning the values
  public function __construct($id, $firstname, $lastname, $gender, $descID, $age, $temperment) {
   $this->id = $id;
   $this->firstname = $firstname;
   $this->lastname = $lastname;
   $this->gender = $gender;
   $this->descID = $descID;
   $this->age = $age;
   $this->temperment = $temperment;
   //$this->$emotional_state = $emotional_state;
  }

  /**
   * @return a formatted string containing some character information
   **/
  public function describe() {
   return "Name: " . $this->firstname . " " . $this->lastname . "<br>"
          ."Age: ". $this->age ."<br>Gender: " . $this->gender . "<br>"
          ."Description: ". $this->temperment."<br>";
  }

  public function kill(){
   $this->isAlive = false;
  }

  /**
   * @param the emotional_state to update the character and their arc with
   * @param the description of the emotional state
   * Updates the characters current es and arcs with the specified values
   **/
  public function updateES($emotional_state, $es_desc){
   $this->emotional_state = $this->emotional_state + $emotional_state;
   $this->es_desc = $es_desc;
   /*Update the character arcs*/
   $this->arc_es.=",".$this->emotional_state;
   $this->arc_desc.=",".$es_desc;
  }
}

/*
 * The story class that holds all the data that is passed
 * into the knowledge base.
 *
 */
class Story {
  public $story_id;
  public $event_sequence;
  public $location_sequence;
  public $action_sequence;
  public $rating;
  public $respect_death;
  public $allow_doppelgangers;
  public $character_motive;
  public $invert_cm;
  public $markov_event;
  public $markov_location;
  public $markov_action;
  public $random_action;
  public $action_choice;
  public $location_choice;
  public $event_choice;
  public $n_gram_size;


  /**
   * @param an action ID to add to the action sequence
   **/
  public function updateActionSeq($action_id){
    $this->action_sequence.=",".$action_id;
  }

  /**
   * @param an event ID to add to the event sequence
   **/
  public function updateEventSeq($event_id){
    $this->event_sequence.=",".$event_id;
  }

  /**
   * @param a location ID to add to the location sequence
   **/
  public function updateLocationSeq($location_id){
    $this->location_sequence.=",".$location_id;
  }

  /**
   * @return true if succesful else return the error
   * Insert the story to the evaluated_story table
   **/
  public function saveStory(){
    global $saveStoryInsert;

    $saveStory = $saveStoryInsert."('".trim($this->event_sequence, ',')."','".trim($this->location_sequence, ',')."','"
    .trim($this->action_sequence, ',')."','".$this->rating."',".$this->respect_death.",".$this->allow_doppelgangers.",'".$this->action_choice."','".$this->location_choice."','".$this->event_choice."');";

    $result = executeInsert($saveStory);

    if($result == true){
      return true;
    }
    else {
      return "Story Insert: ".$result;
    }
  }
/**
 * Insert the characters into the character_obj table
 * @param the character to insert
 * @return true if succesful else return the error
 **/
  public function saveCharacter($char1){
    global $saveCharacterInsert;
    //Serialize the character
    $serializedChar = Serialize($char1);
    //Save the serialized characters
    $saveChar = $saveCharacterInsert."'".$serializedChar."',(SELECT MAX(story_id) FROM evaluated_story));";

    $resultChar = executeInsert($saveChar);
    //$resultChar = true;

    if($resultChar == true){
      return true;
    }
    else {
      return "<br>Character Insert: ".$resultChar;
    }
  }
}


/*
 * A class for the locations and their components
 */
class Location {
  public $id;
  public $name;
  public $brief;
  public $longDesc;

  //constructor
  public function __construct($id, $name, $brief, $longDesc){
    $this->id = $id;
    $this->name = $name;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
  }
  }

  /*
   * A class for the action and their components
   */
class Action {
  public $id;
  public $brief;
  public $longDesc;
  public $tone;
  public $consequence;
  public $conBrief;
  public $con_desc;
  public $c1_es;
  public $c2_es;
  public $c1_es_desc;
  public $c2_es_desc;
  public $is_dead;
  public $invert_c1_c2;//may have to have 2 for action and consequence
  public $solo_action;
  public $protagonist;

  //constructor
  public function __construct($id, $brief, $longDesc, $tone, $consequence, $conBrief,$con_desc, $c1_es, $c2_es, $c1_es_desc, $c2_es_desc, $is_dead, $invert_c1_c2, $solo_action){
    $this->id = $id;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
    $this->tone = $tone;
    $this->consequence = $consequence;
    $this->conBrief = $conBrief;
    $this->con_desc = $con_desc;
    $this->c1_es = $c1_es;
    $this->c2_es = $c2_es;
    $this->c1_es_desc = $c1_es_desc;
    $this->c2_es_desc = $c2_es_desc;
    $this->is_dead = $is_dead;
    $this->invert_c1_c2 = $invert_c1_c2;
    $this->solo_action = $solo_action;
  }
}

/*!!Depercated!!*/
class ActionCon {
  public $id;
  public $brief;
  public $longDesc;
  public $tone;

  //constructor
  public function __construct($id, $brief, $longDesc, $tone){
    $this->id = $id;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
    $this->tone = $tone;
  }
}

 /*
  * A class for the events and their components
  */
class Event {
  public $id;
  public $brief;
  public $longDesc;
  public $tone;
  public $consequence;
  public $conBrief;
  public $con_desc;

  //constructor
  public function __construct($id, $brief, $longDesc, $tone, $consequence, $conBrief, $con_desc){
    $this->id = $id;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
    $this->tone = $tone;
    $this->consequence = $consequence;
    $this->conBrief = $conBrief;
    $this->con_desc = $con_desc;
  }
}

/*!!Depercated!!*/
class EventCon {
  public $id;
  public $brief;
  public $longDesc;
  public $tone;
  //public $event_id;

  //constructor
  public function __construct($id, $brief, $longDesc, $tone){
    $this->id = $id;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
    $this->tone = $tone;
   }
}

/*
 * Run cycles of actions, locations or events with different parameters
 * for the rulesets involved
 * TODO refactor to extend StoryMaker - Change creation statements?
 * TODO when refactored move getXbyID functions to StoryMaker
 */
class ReflectionCycle{
  private $reflectSM;

  //Constructor get a StoryMaker object to use
  public function __construct(StoryMaker $reflectSM){
    $this->reflectSM = $reflectSM;
  }

   /*
   *TODO refactor actionCycle and eventCycle functions to have generic private
   * functions that they call and different parameters or event/actionCycle
   * functions that set the rulesets used e.g. one for using Markov - one for
   * character motivations
   *TODO have an actionCycle that repeats until 1 character is happy or both characters are happy/unhappy
   */

   /**
    * Pick an action based on character's emotional states
    * TODO refactor so only 1 return ...
    * @param char1 a person object type
    * @param char2 a person object type
    * @return an action - also updates c1_es and c2_es and arcs
    * Then run cycle again - can be done in a loop in another function
    **/
    public function actionCycleCM($char1, $char2){
      //Use the global queries
      global $actionStatementGet;
      //If both characters have an equal emotional_state, have none set or emotional_state isn't being used, then just select an action at random
      if($char1->emotional_state == $char2->emotional_state){
        return $this->actionCycleRandom($char1, $char2);
      }
      //Check to see which character is least happy
      //Pick an action that will improve their mood
      elseif ($char1->emotional_state < $char2->emotional_state) {
        $whereCondition = "WHERE ac.c1_es > 0";
        $charToUpdate = 'c1';
      }
      //Char2 must be less happy so choose an action that will improve their mood
      else {
        $whereCondition = "WHERE ac.c2_es > 0"; //could be >= ??
        $charToUpdate = 'c2';
      }
      $actionStatement = $actionStatementGet.$whereCondition." ORDER BY RAND() LIMIT 1;";
      $currentAction = $this->reflectSM->getAction($actionStatement);
      //update character states
      $this->updateCharFromAction($currentAction, $char1, $char2, $charToUpdate);
      //return the action
      return $currentAction;
    }

    /**
     * Pick a random action and update the characters
     * @param char1 a person object type
     * @param char2 a person object type
     * @return an action - also updates c1_es and c2_es and arcs
     **/
     public function actionCycleRandom($char1, $char2){
       //Use the global queries
       global $actionStatementGet;
       $currentAction = $this->pickRandomAction();
       //Update the character states
       $this->updateCharFromAction($currentAction, $char1, $char2, 'c1');
       return $currentAction;
     }

    /**
     * @param id of the action to return
     * @return action with the specified ac_id
     * TODO sanitise the ID passed in?
     **/
     public function getActionByID(int $ac_id, $char1, $char2){
        global $actionStatementGet;
        $actionStatement = $actionStatementGet."AND action.ac_id = ".$ac_id." ;";
        $action = $this->reflectSM->getAction($actionStatement);
        $this->updateCharFromAction($action, $char1, $char2, 'c1');
        return $action;
     }

   /**
    * Update the characters based on the action
    * @param the action to update characters from
    * @param char1 a person object type
    * @param char2 a person object type
    * @param the character that should be updated
    * @Return an action - also updates c1_es and c2_es and arcs
    **/
    public function updateCharFromAction($action, $char1, $char2, $charToUpdate){
     if($action->solo_action == 1){ //if it's a solo action update the right character
       if($charToUpdate == 'c1'){
         $char1->updateES($action->c1_es, $action->c1_es_desc);
         $char2->updateES(0, $char2->es_desc); //just keep character 2's arc the same
         $action->protagonist = $charToUpdate;
       }
       else {
         $char2->updateES($action->c2_es, $action->c2_es_desc);
         $char1->updateES(0, $char1->es_desc); //just keep character 1's arc the same
         $action->protagonist = $charToUpdate;
       }
     }
     else{ //if it's not a solo action update both
       $char1->updateES($action->c1_es, $action->c1_es_desc);
       $char2->updateES($action->c2_es, $action->c2_es_desc);
     }
    }
    /*
     * Pick an action at random and return it
     */
     public function pickRandomAction(){
        global $actionStatementGet;
        $actionStatement = $actionStatementGet."ORDER BY RAND() LIMIT 1;";
        return $this->reflectSM->getAction($actionStatement);
     }

     /**
      * @param id of the event to return
      * @return event with the specified event_id
      * TODO sanitise the ID passed in?
      * TODO Move to StoryMaker class
      **/
     public function getEventByID($event_id){
       global $eventStatementGet;
       $eventStatement =  $eventStatementGet." WHERE event.event_id = ".$event_id.";";
       return $this->reflectSM->getEvent($eventStatement);
     }

    /**
     * Pick a new event at random and return it
     **/
    public function pickRandomEvent(){
      global $eventStatementGet;
      $eventStatement =  $eventStatementGet." ORDER BY RAND() LIMIT 1;";
      return $this->reflectSM->getEvent($eventStatement);
    }

    /**
     * @param id of the location to return
     * @return location with the specified location_id
     * TODO sanitise the ID passed in?
     * TODO Move to StoryMaker class
     **/
    public function getLocationByID($loc_id){
      global $locationStatementGet;
      $locationStatement = $locationStatementGet." WHERE location.loc_id = ".$loc_id.";";

      //Return a location
      return $this->reflectSM->getLocation($locationStatement);
    }

   /**
    * Pick a new event at random and return it
    * eventCycle should get
    */
   public function pickRandomLocation(){
     global $locationStatementGet;
     $locationStatement = $locationStatementGet."ORDER BY RAND() LIMIT 1;";

     //Return a location
     return $this->reflectSM->getLocation($locationStatement);
   }
 }


/**
 * Currently !!Deprecated!! ...JS implementation used instead in AJAX call
 *
 */
class Markov {

  public function buildNgrams($src, $n){
   $ngrams = array();

   for ($i=0; $i <= strlen($src)-$n; $i++) {
     $gram = substr($src, $i, $n);
     //echo $gram."<br>";
     if(!in_array($gram, $ngrams)){
       $ngrams[$gram] = array();//array_push then array_push?
       //echo $i;
       //array_push($ngrams, $gram);
     }
     //array_push($ngrams[$gram], substr($src, $i+$n, 1));
     $ngrams[$gram] = substr($src, $i+$n, 1);//save as string here then turn into array?
   }
   //var_dump($ngrams);
   return $ngrams;
  }

  function Ngrams($word,$n){
    $len=strlen($word);
    $ngram=array();
    for($i=0;$i+$n<=$len;$i++){
        $string="";
        for($j=0;$j<$n;$j++){
            $string.=$word[$j+$i];
        }
        $ngram[$i]=$string;
    }
        return $ngram;
  }
}


/**
 *For testing the getLocation/Action/Event functions used in getStory.php
 */
class StoryMaker {

  /**
   * @return a person object
   * Make a random character and return an object of type Person
   */
   public function makeCharacter(){
     global $characterStatementGet;
     $characterStatement = $characterStatementGet." ORDER BY RAND() LIMIT 1;";

     return $this->returnCharacter($characterStatement);
   }

   /**
    * @param the id of the character to create
    * @return a person object
    * Make a character based on the ID return an object of type Person (chooses attributes logically)
    */
    public function getCharacterByID($c_id){
      global $characterStatementGet;
      $characterStatement = $characterStatementGet." WHERE s_character.c_id = ".$c_id.";";

      return $this->returnCharacter($characterStatement);
    }

    /**
     * @param the id of the character NOT to create
     * @return a person object
     * Make a random character who isn't identified by the ID. Return an object of type Person (chooses attributes logically)
     */
     public function getCharacterWhoIsnt($c_id){
       global $characterStatementGet;
       $characterStatement = $characterStatementGet." WHERE s_character.c_id != ".$c_id." ORDER BY RAND() LIMIT 1;";

       return $this->returnCharacter($characterStatement);
     }

   /**
    * @param a SQL statement returning the character constructor attributes
    * @return a character using the results returned by the statement or false
    */
    public function returnCharacter($characterStatement){
      $resultC = executeQuery($characterStatement);
      $sizeC = count($resultC);

      if($sizeC != 0){

        foreach ($resultC as $rowC) {
          //Create a person object for each selected character with a person1...X naming scheme
          return new Person($rowC['c_id'], $rowC['fName'], $rowC['lName'], $rowC['gender'], $rowC['c_desc'], $rowC['age'], $rowC['temperment']);
        }
      }
      if($sizeC == 0){
        return false;
      }
    }

  /**
   * execute LOCATION statements
   * @param a sql query returning one row from
   * the location table
   * @return a location object else false
   */
  public function getLocation($query){
    $resultL = executeQuery($query);
    $sizeL = count($resultL);

    //get location details
    if($sizeL != 0){ //TODO?: should perhaps be == 1 to avoid returning multiple objects/put in for loop with 1 iteration rather than foreach
      foreach ($resultL as $rowL) {
        //Create a location object for each selected location
        return new Location($rowL['loc_id'], $rowL['name'], $rowL['brief'], $rowL['long_desc']);
      }
    }
    if($sizeL == 0){ //If above conditional is changed to ==1 then make this an else rather than if statement
      return false;
    }
  }

  /**
   * Execute ACTION statements
   * @param a sql query returning a row from action and
   * the consequence from action_consequence as con_brief
   * @Return an action object else false
   */
  public function getAction($query){
    $resultA = executeQuery($query);
    $sizeA = count($resultA);

    if($sizeA != 0){
      foreach ($resultA as $rowA) {
        //Create an action object for each selected action
        return new Action($rowA['ac_id'], $rowA['brief'], $rowA['long_desc'], $rowA['tone'], $rowA['consequence'], $rowA['con_brief'], $rowA['con_long'], $rowA['c1_es'], $rowA['c2_es'], $rowA['c1_es_desc'], $rowA['c2_es_desc'], $rowA['is_dead'], $rowA['invert_c1_c2'], $rowA['solo_action']);
      }
    }
    if($sizeA == 0){
      return false;
    }
  }

  /**
   * Execute EVENT statements
   * @Param a query returning event class constructor params
   * @Return an event else false
   */
  public function getEvent($query){
    $resultE = executeQuery($query);
    $sizeE = count($resultE);

    //get event details
    if($sizeE != 0){
      foreach ($resultE as $rowE) {
        //Create an event object for each selected event
        return new Event($rowE['event_id'], $rowE['brief'], $rowE['long_desc'], $rowE['tone'], $rowE['consequence'], $rowE['con_brief'], $rowE['con_long']);
      }
    }
    if($sizeE == 0){
      return false;
    }
   }

   /**
    * @param the table to check the element exists in
    * @param the id of the element to check for
    * @return true if the element exists, else false
    */
   public function checkExists($table, $value){
     /**Include the global queries variables*/
     global $checkExistsEvent, $checkExistsAction, $checkExistsLocation;
     //Quick sanity check of $value
     if($value == '' || $value == ', '){
       return false;
     }

     if($table == 'event'){
       $base = $checkExistsEvent;
     }
     elseif ($table == 'action') {
       $base = $checkExistsAction;
     }
     elseif ($table == 'location') {
       $base = $checkExistsLocation;
     }
     $query = $base." ".$value.";";
     $result = executeQuery($query);
     $size = count($result);

     if($size != 0){
       return true;
     }
     if($size == 0){
       return false;
     }
   }

   /**
    * !!Deprecated!!
    *Return the frequency of the event, location and action occurences in the kb
    *TODO Move out of StoryMaker class
    *-can then check for single events/locations/actions frequency
    */
   function getStoryStatistics($eventSequence, $locationSequence, $actionSequence){
     //global $conn;
     $goodInfoQ = "SELECT * FROM good_story;";
     $results = executeQuery($goodInfoQ);
     $size = count($results);

     if($size != 0){
    	   $eventArray = array();
      	 $locationArray = array();
      	 $actionArray = array();

      	  foreach ($results as $row) {
      		     $eventArray[] = $row['event_sequence'];
      		     $locationArray[] = $row['location_sequence'];
      		     $actionArray[] = $row['action_sequence'];
      	  }
        $stats = array();//Make an array list to return the stats in
        /*Get the most popular event details*/
        $e = array_count_values($eventArray);
        $eventSize = count($eventArray);
        //var_dump(strlen($eventSequence));
        if(strlen($eventSequence) == 2){$eventSequence = $eventSequence+0;} //Force type to int to use as an array index
        //Give the number of events/actions/locations to stats (only one index now should be one for each category)
        $stats["kbSize"] = $eventSize;
        //Check frequency if event has appaered before
        if(isset($e[$eventSequence])){
          $eventPer = round($e[$eventSequence] / $eventSize * 100, 2);
          $eventFreq = $e[$eventSequence];
          $stats["eventPer"] = $eventPer;
          $stats["eventFreq"] = $eventFreq;
        }
        if(!isset($e[$eventSequence])){
            $eventPer = 0;
            $eventFreq = 0;
            $stats["eventPer"] = $eventPer;
            $stats["eventFreq"] = $eventFreq;
          }

        /*Get the most popular location details*/
        $l = array_count_values($locationArray);
        $locationSize = count($locationArray);
        if(strlen($locationSequence) == 2){$locationSequence = $locationSequence+0;}//Force type to int to use as an array index
        if(isset($l[$locationSequence])){
          $locPer = round($l[$locationSequence] / $locationSize * 100, 2);
          $locFreq = $l[$locationSequence];
          $stats["locPer"] = $locPer;
          $stats["locFreq"] = $locFreq;
        }
        else{
          $locPer = 0;
          $locFreq = 0;
          $stats["locPer"] = $locPer;
          $stats["locFreq"] = $locFreq;
        }

        /*Get the most popular action details*/
        $a = array_count_values($actionArray);
        $actionSize = count($actionArray);
        if(strlen($actionSequence) == 2){$actionSequence = $actionSequence+0;}//Force type to int to use as an array index
        if(isset($a[$actionSequence])){
          $acFreq = $a[$actionSequence];
          $acPer = round($a[$actionSequence] / $actionSize * 100, 2);
          $stats["acPer"] = $acPer;
          $stats["acFreq"] = $acFreq;
        }
        else{
          $acFreq = 0;
          $acPer = 0;
          $stats["acPer"] = $acPer;
          $stats["acFreq"] = $acFreq;
        }
        return $stats;

     }
     if($size == 0){
       return false;
     }
   }
}
?>
