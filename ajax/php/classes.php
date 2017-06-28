<?php
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

            // Assigning the values
            public function __construct($id, $firstname, $lastname, $gender, $descID, $age, $temperment) {
              $this->id = $id;
              $this->firstname = $firstname;
              $this->lastname = $lastname;
              $this->gender = $gender;
              $this->descID = $descID;
              $this->age = $age;
              $this->temperment = $temperment;
            }

            // Creating a method (function tied to an object)
            public function describe() {
              return "Name: " . $this->firstname . " " . $this->lastname . "<br>"
                     ."Age: ". $this->age ."<br>Gender: " . $this->gender . "<br>"
                     ."Description: ". $this->temperment."<br>";
            }

            public function kill(){
              $this->isAlive = false;
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

      //constructor
      public function __construct($id, $brief, $longDesc, $tone, $consequence, $conBrief){
        $this->id = $id;
        //$this->name = $name;
        $this->brief = $brief;
        $this->longDesc = $longDesc;
        $this->tone = $tone;
        $this->consequence = $consequence;
        $this->conBrief = $conBrief;
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
 *For testing the getLocation/Action/Event functions used in getStory.php
 */
class StoryMaker {

  //TODO?: getLocation/Action/Event functions could all be one function with case statements (perhaps less clear?)

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
        return new Action($rowA['ac_id'], $rowA['brief'], $rowA['long_desc'], $rowA['tone'], $rowA['consequence'], $rowA['con_brief']);
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
