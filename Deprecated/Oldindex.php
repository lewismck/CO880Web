<!DOCTYPE html>
<html>
<!-- Presents a button to generate stories and some information on the state of the knowledge base (retrieved from storydata.php) -->
<head>
	<meta charset="utf-8">
	<!-- bootstrap for styling -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <!-- Bootstrap and jquery js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!-- Project specific JS - Makes calls to different PHP scripts which in turn call functions in this file -->
	<script src="ajax/js/phpcalls.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Test CO880</title>
</head>
<body onload="getData();">

	<h1>CO880 Web Test</h1>
	<!-- <h4>Character Limit: <input type="range" min="2" max="9" id='charcount'></h4> -->
	<a class='btn btn-default' onclick="generateStory('n');">Generate Story</a><br><br>
	<div id="storyBox" class='col-md-8'></div>

	<h1>(Good) Story Data:</h1>
	<div id='dataBox' class='col-md-4'></div>
</body>
</html>
