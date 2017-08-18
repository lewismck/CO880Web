<!DOCTYPE html>
<html>
<!--
		Presents a button to generate stories and buttons to view params and log the stories to the console
		@author Lewis Mckeown
 -->
<head>
	<meta charset="utf-8">
	<link href="http://fonts.googleapis.com/css?family=Lato:100,300,400" rel="stylesheet" type="text/css">
	<!-- bootstrap for styling -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
 <!-- Bootstrap and jquery js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <!-- Project specific JS - Makes calls to different PHP scripts which in turn call functions in this file -->
	<script src="ajax/js/phpcalls.js"></script>
	<!-- Project specific styles -->
	<link rel="stylesheet" href="Styles/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CO880 Generator</title>
</head>
<!-- onload function should be setup that calls the setup function in main.php -->
<body onload="mainSetup();">
	<div id="mainBody" class="col-md-12 text-center">
		<h1>CO880 Generator</h1>
		<form action="javascript:getStory();">
			<fieldset>
			 	<div id="dynamicStoryParams" class="form-group">
					<!--  Params returned here by mainSetup() -->
				</div>
				<div id="storyParams">
					<label>Action Choice: </label><br>
	        <input type="radio" name="action_choice" value="cm" onchange="disableSeed()" checked> Character Motivation<br>
	        <input type="radio" name="action_choice" value="markov" onchange="disableSeed()" > Markov Chain<br>
	        <input type="radio" name="action_choice" value="random" onchange="disableSeed()"> Random<br>
	        <label>Event Choice: </label><br>
	        <input type="radio" name="event_choice" value="markov" onchange="disableSeed()" checked> Markov Chain<br>
	        <input type="radio" name="event_choice" value="random" onchange="disableSeed()"> Random<br>
	        <label>Location Choice: </label><br>
	        <input type="radio" name="location_choice" value="markov" onchange="disableSeed()" checked> Markov Chain<br>
	        <input type="radio" name="location_choice" value="random" onchange="disableSeed()"> Random<br>
	        <label>Allow Doppelgangers: </label><br>
	        <label class="switch">
		  	    <input type="checkbox" id="allow_dop">
	  	      <span class="slider round"></span>
	        </label>
	      	<br>
	      	<label>Respect Death: </label><br>
	        <label class="switch">
		  	    <input type="checkbox" id="rd">
	  	      <span class="slider round"></span>
	        </label><br>
					<input type="submit" value="Generate" class="btn btn-primary"></br></br>
				</div>
			</fieldset>
		</form>
		<blockquote>
			<div id="outlineBox" class=".col-md-8 .col-md-offset-4"></div>
		</blockquote>
		</br>
		<div id="evaluateBox" class=".col-md-8 .col-md-offset-4"></div></br>
	</div>
	<div class="col-md-12 row">
		<div class="col-md-8 col-md-offset-2 text-center">
			<!-- Select a dataset and log the stories generated so far to the command line in a way that's usable as elements in a js array  -->
			<select id="dataSet">
				<option value="unconstrained">unconstrained</option>
				<option value="moderatelyConstrained1" selected>moderatelyConstrained1</option>
				<option value="moderatelyConstrained2">moderatelyConstrained2</option>
				<option value="moderatelyConstrained3">moderatelyConstrained3</option>
				<option value="tightlyConstrained">tightlyConstrained</option>
			</select>
			<button type="button" class="btn btn-default" onclick="logGeneratedStories();">Log Stories</button><br><br>
			<!-- View the passed parameters and returned data  -->
			<button type="button" class="btn btn-default" data-toggle="modal" data-target="#paramsModal">View Params</button><br><br>
		</div>
	</div>

	<div class="col-md-12 row">
		<!-- Include the generic footer -->
		<?php include 'ajax/php/footer.php'; ?>
	</div>

	<!-- Modals -->
	<!-- Params -->
	<div id="paramsModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- content -->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Params</h4>
	      </div>
	      <div class="modal-body">
	        <div id="storyBox"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>
