<!DOCTYPE html>
<html>
<!-- Contains charts and data about the evaluated stories and user feedback -->
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
	<script src="Charts/Libraries/chart.js"></script>
	<script src="Charts/storyCharts.js"></script>
	<!-- Project specific styles -->
	<link rel="stylesheet" href="Styles/main.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CO880 Stats</title>
</head>
<!-- onload function should be setup that calls the getChartData function in main.php -->
<body onload="chartSetup();">
<div class="col-md-12 row">
	<div id="mainBody" class="col-md-12 text-center">
		<h1>CO880 Stats</h1>
		<br>
	</div>
</div>
<div class="col-md-12 row">
	<h1>Story Constraints</h1>
</div>
<div class="col-md-12 row">
	<div class="col-md-6">
		<h4 class="text-center">Story Choice Breakdown</h4>
		<canvas id="comparison-story-chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas>
	</div>
	<div class="col-md-6">
		<h4 class="text-center">Story Constraints</h4>
		<h5 class="text-center">Binary Toggles</h4>
		<canvas id="comparison-story-chart-2" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas>
	</div>
</div>
<div class="col-md-12 row">
	<br>
	<h1>Story Component Breakdowns</h1>
	<br>
</div>
<div class="col-md-12 row">
	<div class="col-md-4">
		<h4 class="text-center">Action Frequency</h4>
		<canvas id="action_frequency_chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas><br>
	</div>
	<div class="col-md-4">
		<h4 class="text-center">Event Frequency</h4>
		<canvas id="event_frequency_chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas><br>
	</div>
	<div class="col-md-4">
		<h4 class="text-center">Location Frequency</h4>
		<canvas id="location_frequency_chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas><br>
	</div>
</div>

<div class="col-md-12 row">
	<!-- Include the generic footer -->
	<?php include 'ajax/php/footer.php'; ?>
</div>

	<!-- Modals -->
	<!-- Charts and Data -->
	<div id="chartsModal" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">
	    <!-- content -->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Charts and Data</h4>
	      </div>
	      <div class="modal-body">
					<div id="chartData"></div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>
</body>
</html>
