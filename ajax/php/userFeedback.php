<?php
//Require the connect function for the database
require_once('connect.php');
$conn = connect();
// Check it
if (!$conn){
   die("Connection failed: " .  conn_connect_error());
 }

 if(isset($_GET['story_id'])){
   //sanitise the input
   $saveEvaluationStatement = $conn->prepare("INSERT INTO user_feedback (story_id, dataset, creativity_rating, liked) VALUES(?,?,?,?);");

   //Quickly build a query to send the data back and execute
   $result = $saveEvaluationStatement->execute(array($_GET['story_id'],$_GET['dataset'],$_GET['creativity_rating'],$_GET['liked']));

   if($result){
     echo "Evaluated succesfully.";
   }
   else{
     echo "<br><strong>Something went wrong. Check logs?</strong><br>";
   }
 }

else{
  echo "Something went wrong.<br>";
}

 ?>
