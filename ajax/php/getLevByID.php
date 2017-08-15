<?php
/**
 * @author Lewis Mckeown
 * This code will form part of the corpus for my MSc submission
 * Following this it will probably be available on github.
 **/

//Require the connect function for the database
require_once('connect.php');
$conn = connect();
// Check it
if (!$conn){
   die("Connection failed: " .  conn_connect_error());
 }
 //Require the classes file
 require_once('classes.php');

 $main = new Main();

if(isset($_GET['story_id'])){
  $getStoryData = "SELECT * FROM evaluated_story WHERE story_id =".$_GET['story_id'].";";
  $result = executeQuery($getStoryData);
  $size = count($result);

  if($size != 0){
    echo "<h1>Levenshtein Distance for Story: ".$_GET['story_id']."</h1>";
    foreach ($result as $row) {
    $loc_lev = $main->getLevenshteinDistance($row['location_sequence'], 'location', 'g');
    $ac_lev = $main->getLevenshteinDistance($row['action_sequence'], 'action', 'g');
    $ev_lev = $main->getLevenshteinDistance($row['event_sequence'], 'event', 'g');
    echo "Location: ".$loc_lev."<br>";
    echo "Action: ".$ac_lev."<br>";
    echo "Event: ".$ev_lev."<br>";
    }

    $story_lev = ($ac_lev + $loc_lev + $ev_lev) /3;
    echo "Story Lev Rating: ".$story_lev;
  }
  if($size == 0){
    echo "No data found.";
  }
}


 ?>
