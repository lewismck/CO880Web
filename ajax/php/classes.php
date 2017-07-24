<?php
class Main {

  /*
   * Query all the story data from the KB and set it as javascript variables
   *
   *
   */
  public function setup(){

    $KBQuery = "SELECT
                  GROUP_CONCAT(TRIM(event_sequence) SEPARATOR '') event_seq
                , GROUP_CONCAT(TRIM(action_sequence) SEPARATOR '') action_seq
                , GROUP_CONCAT(TRIM(location_sequence) SEPARATOR '') location_seq
                FROM good_story;";
    $KBData = executeQuery($KBQuery);
    $event_seq = $KBData[0]['event_seq'];
    $action_seq = $KBData[0]['action_seq'];
    $location_seq = $KBData[0]['location_seq'];
    // echo "<script> var ev_seq1 = '".$event_seq."';</script>";
    // echo "<script> var ac_seq1 = '".$action_seq."';</script>";
    // echo "<script> var loc_seq1 = '".$location_seq."';</script>";

    //return a KB_Data object
    $kbData = new KB_Data($action_seq, $event_seq, $location_seq);
    return $kbData;
  }


  /*
   * @param array (_GET/_POST) containing parameters to be parsed.
   * TODO sanitise inputs
   */
  public function parseParams($params){
    $parsedParams = new ParsedParams();
    foreach($params as $key => $value){
      //echo "$key: $value<br />";
      if($key == 'func'){
        $parsedParams->func = $value;
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
      elseif($key == 'no_dop'){
        $parsedParams->no_doppelgangers = $value;
      }
      elseif($key == 'rd'){
        $parsedParams->respect_death = $value;
      }
    }
    return $parsedParams;
  }
}

class KB_Data {
        public $action_seq;
        public $event_seq;
        public $location_seq;

        //constructor
        public function __construct($action_seq, $event_seq, $location_seq){
          $this->action_seq = $action_seq;
          $this->event_seq = $event_seq;
          $this->location_seq = $location_seq;
        }
}

class ParsedParams {
        public $func;
        public $ev_cycle_count;
        public $ac_cycle_count;
        public $loc_cycle_count;
        public $ac_seq;
        public $ev_seq;
        public $loc_seq;
        public $no_doppelgangers;
        public $respect_death;
}
/*
 *Classes for the main story components: Person, Location, Action, Event (& their consequences)
 *Also contains a StoryMaker class with functions for creating and returning the story components-
 *-and a function for evaluating stories
 *Allows for object creation and re-use. Objects are be passed to js as JSON objects.
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
             public $es_desc = 'x';
             public $arc_es = '';
             public $arc_desc = '';

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

             // Return a formatted string containing some character information
             public function describe() {
               return "Name: " . $this->firstname . " " . $this->lastname . "<br>"
                      ."Age: ". $this->age ."<br>Gender: " . $this->gender . "<br>"
                      ."Description: ". $this->temperment."<br>";
             }

             public function kill(){
               $this->isAlive = false;
             }

             public function updateES($emotional_state, $es_desc){
               $this->emotional_state = $this->emotional_state + $emotional_state;
               $this->es_desc = $es_desc;
             }
  }

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

class Action {
      public $id;
      //public $name;
      public $brief;
      public $longDesc;
      public $tone;
      public $consequence;
      public $conBrief;
      public $c1_es;
      public $c2_es;
      public $c1_es_desc;
      public $c2_es_desc;
      public $is_dead;

      //constructor
      public function __construct($id, $brief, $longDesc, $tone, $consequence, $conBrief, $c1_es, $c2_es, $c1_es_desc, $c2_es_desc, $is_dead){
        $this->id = $id;
        //$this->name = $name;
        $this->brief = $brief;
        $this->longDesc = $longDesc;
        $this->tone = $tone;
        $this->consequence = $consequence;
        $this->conBrief = $conBrief;
        $this->c1_es = $c1_es;
        $this->c2_es = $c2_es;
        $this->c1_es_desc = $c1_es_desc;
        $this->c2_es_desc = $c2_es_desc;
        $this->is_dead = $is_dead;
      }
 }

class ActionCon {
  public $id;
  //public $name;
  public $brief;
  public $longDesc;
  public $tone;
  //public $ac_id;

  //constructor
  public function __construct($id, $brief, $longDesc, $tone){
    $this->id = $id;
    //$this->name = $name;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
    $this->tone = $tone;
  //  $this->ac_id = $ac_id;
  }

 }

class Event {
      public $id;
      //public $name;
      public $brief;
      public $longDesc;
      public $tone;
      public $consequence;
      public $conBrief;

      //constructor
      public function __construct($id, $brief, $longDesc, $tone, $consequence, $conBrief){
        $this->id = $id;
      //  $this->name = $name;
        $this->brief = $brief;
        $this->longDesc = $longDesc;
        $this->tone = $tone;
        $this->consequence = $consequence;
        $this->conBrief = $conBrief;
      }
 }

class EventCon {
  public $id;
  //public $name;
  public $brief;
  public $longDesc;
  public $tone;
  //public $event_id;

  //constructor
  public function __construct($id, $brief, $longDesc, $tone){
    $this->id = $id;
    //$this->name = $name;
    $this->brief = $brief;
    $this->longDesc = $longDesc;
    $this->tone = $tone;
    //$this->event_id = $event_id;
   }

 }

/*
 * Run cycles of actions or events with different parameters
 * for the rulesets involved
 * TODO refactor to extend StoryMaker - Change creation statements
 * TODO when refactored move getXbyID functions to StoryMaker
 */
 class ReflectionCycle{
  private $reflectSM;

  //Constructor get a StoryMaker object to use
  public function __construct(StoryMaker $reflectSM){
    $this->reflectSM = $reflectSM;
  }

   //Create an instance of the StoryMaker class to use for reflection cycles
   //$reflectSM = new StoryMaker();
    /*
     *TODO refactor actionCycle and eventCycle functions to have generic private
     * functions that they call and different parameters or event/actionCycle
     * functions that set the rulesets used e.g. one for using Markov - one for
     * character motivations
     *TODO have an actionCycle that repeats until 1 character is happy or both characters are happy/unhappy
     */

     /*
      * TODO refactor so only 1 return ...
      * @param char1 a person object type
      * @param char2 a person object type
      * @Return an action - can use the action to update c1_es and c2_es
      * Then run cycle again - can be done in a loop in another function
      */
    public function actionCycleCM($char1, $char2){
      //If both characters have an equal emotional_state or have none set then just select an action at random
      if($char1->emotional_state == $char2->emotional_state){
        $currentAction = $this->pickRandomAction();
        //Update the character states
        $char1->updateES($currentAction->c1_es, $currentAction->c1_es_desc);
        $char2->updateES($currentAction->c2_es, $currentAction->c2_es_desc);
        return $currentAction;
      }
      //Check to see which character is least happy
      //Pick an action that will improve their mood
      elseif ($char1->emotional_state < $char2->emotional_state) {
        $whereCondition = "WHERE ac.c1_es > 0";
      }
      //Char2 must be less happy so choose an action that will improve their mood
      else {
        $whereCondition = "WHERE ac.c2_es > 0"; //could be >= ??
      }
      $actionStatement = "SELECT action.*
                          , ac.brief AS con_brief
                          , ac.long_desc AS con_long
                          , ac.tone AS con_tone
                          , ac.c1_es
                          , ac.c2_es
                          , ac.c1_es_desc
                          , ac.c2_es_desc
                          , ac.is_dead
                          FROM action
                          JOIN action_consequence ac ON action.consequence=ac.con_id ".
                          $whereCondition.
                          " ORDER BY RAND() LIMIT 1;";
      $currentAction = $this->reflectSM->getAction($actionStatement);
      //update character states
      $char1->updateES($currentAction->c1_es, $currentAction->c1_es_desc);
      $char2->updateES($currentAction->c2_es, $currentAction->c2_es_desc);
      return $currentAction;
    }

    /*
     * @param id of the action to return
     * @return action with the specified ac_id
     * TODO sanitise the ID passed in?
     */
     public function getActionByID(int $ac_id){
       $actionStatement = "SELECT action.*
                           , ac.brief AS con_brief
                           , ac.long_desc AS con_long
                           , ac.tone AS con_tone
                           , ac.c1_es
                           , ac.c2_es
                           , ac.c1_es_desc
                           , ac.c2_es_desc
                           , ac.is_dead
                           FROM action
                           JOIN action_consequence ac ON action.consequence=ac.con_id
                           AND action.ac_id = ".$ac_id." ;";
        return $this->reflectSM->getAction($actionStatement);
     }
    /*
     * Pick an action at random and return it
     */
     private function pickRandomAction(){
       $actionStatement = "SELECT action.*
        , ac.brief AS con_brief
        , ac.long_desc AS con_long
        , ac.tone AS con_tone
        , ac.c1_es
        , ac.c2_es
        , ac.c1_es_desc
        , ac.c2_es_desc
        , ac.is_dead
        FROM action
        JOIN action_consequence ac ON action.consequence=ac.con_id
        ORDER BY RAND() LIMIT 1;";
        return $this->reflectSM->getAction($actionStatement);
     }

     /*
      * @param id of the event to return
      * @return action with the specified event_id
      * TODO sanitise the ID passed in?
      * TODO Move to StoryMaker class
      */
     public function getEventByID($event_id){
       $eventStatement = "SELECT event.*
                          , ec.brief AS con_brief
                          , ec.long_desc AS con_long
                          , ec.tone AS con_tone
                          FROM event
                          JOIN event_consequence ec ON event.consequence = ec.con_id
                          WHERE event.event_id = ".$event_id.";";
       return $this->reflectSM->getEvent($eventStatement);
     }

    /*
     * Pick a new event at random and return it
     * eventCycle should get
     */
    public function pickRandomEvent(){
      $eventStatement = "SELECT event.*
                         , ec.brief AS con_brief
                         , ec.long_desc AS con_long
                         , ec.tone AS con_tone
                         FROM event
                         JOIN event_consequence ec ON event.consequence = ec.con_id
                         ORDER BY RAND() LIMIT 1;";
      return $this->reflectSM->getEvent($eventStatement);
    }
 }


/*
 * Currently not in use...JS implementation used instead in AJAX call
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


/*
 *For testing the getLocation/Action/Event functions used in getStory.php
 */
class StoryMaker {

  /*
   * @return a person object
   * Make a random character and return an object of type Person
   */
   public function makeCharacter(){
     $characterStatement = "SELECT
                              s_character.*
                            , cd.age
                            , cd.temperment FROM s_character
                           JOIN character_desc cd ON s_character.c_desc=cd.desc_id
                           ORDER BY RAND() LIMIT 1;";
     $resultC = executeQuery($characterStatement);
     $sizeC = count($resultC);

     if($sizeC != 0){

       foreach ($resultC as $rowC) {
         //Create a person object for each selected character with a person1...X naming scheme
         return new Person($rowC['c_id'], $rowC['fName'], $rowC['lName'], $rowC['gender'], $rowC['c_desc'], $rowC['age'], $rowC['temperment']);
       }
     }
     if($sizeC == 0){}
       return false;
   }

   /*
    * @param the id of the character to create
    * @return a person object
    * Make a character based on the ID return an object of type Person (chooses attributes logically)
    */
    public function getCharacterByID($c_id){
      $characterStatement = "SELECT
                               s_character.*
                             , cd.age
                             , cd.temperment FROM s_character
                            JOIN character_desc cd ON s_character.c_desc=cd.desc_id
                            WHERE s_character.c_id = ".$c_id.";";
      $resultC = executeQuery($characterStatement);
      $sizeC = count($resultC);

      if($sizeC != 0){

        foreach ($resultC as $rowC) {
          //Create a person object for each selected character with a person1...X naming scheme
          return new Person($rowC['c_id'], $rowC['fName'], $rowC['lName'], $rowC['gender'], $rowC['c_desc'], $rowC['age'], $rowC['temperment']);
        }
      }
      if($sizeC == 0){}
        return false;
    }

    /*
     * @param the id of the character NOT to create
     * @return a person object
     * Make a random character who isn't identified by the ID. Return an object of type Person (chooses attributes logically)
     */
     public function getCharacterWhoIsnt($c_id){
       $characterStatement = "SELECT
                                s_character.*
                              , cd.age
                              , cd.temperment FROM s_character
                             JOIN character_desc cd ON s_character.c_desc=cd.desc_id
                             WHERE s_character.c_id != ".$c_id."
                             ORDER BY RAND() LIMIT 1;";
       $resultC = executeQuery($characterStatement);
       $sizeC = count($resultC);

       if($sizeC != 0){

         foreach ($resultC as $rowC) {
           //Create a person object for each selected character with a person1...X naming scheme
           return new Person($rowC['c_id'], $rowC['fName'], $rowC['lName'], $rowC['gender'], $rowC['c_desc'], $rowC['age'], $rowC['temperment']);
         }
       }
       if($sizeC == 0){}
         return false;
     }

  /*
   * execute LOCATION statements
   * Parameter is a sql query returning one row from
   * the location table
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

  /*
   *execute ACTION statements
   *Parameter is a sql query returning a row from action and
   *the consequence from action_consequence as con_brief
   *query: action.*, action_consequence.brief AS con_brief
   */
  public function getAction($query){
    $resultA = executeQuery($query);
    $sizeA = count($resultA);

    if($sizeA != 0){
      foreach ($resultA as $rowA) {
        //Create an action object for each selected action
        return new Action($rowA['ac_id'], $rowA['brief'], $rowA['long_desc'], $rowA['tone'], $rowA['consequence'], $rowA['con_brief'], $rowA['c1_es'], $rowA['c2_es'], $rowA['c1_es_desc'], $rowA['c2_es_desc'], $rowA['is_dead']);
      }
    }
    if($sizeA == 0){
      return false;
    }
  }

  /*execute EVENT statements*/
  public function getEvent($query){
    $resultE = executeQuery($query);
    $sizeE = count($resultE);

    //get event details
    if($sizeE != 0){
      foreach ($resultE as $rowE) {
        //Create an event object for each selected event
        return new Event($rowE['event_id'], $rowE['brief'], $rowE['long_desc'], $rowE['tone'], $rowE['consequence'], $rowE['con_brief']);
      }
    }
    if($sizeE == 0){
      return false;
    }
   }

   /*
    *Return the frequency of the event, location and action occurences in the knowledge base
    *!!DEPENDENCY: Uses connect.php's connect function
    *TODO: reformat to accept one event type and a flag to indicate what type
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
