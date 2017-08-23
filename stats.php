<!DOCTYPE html>
<html>
<!--
		Contains charts and data about the evaluated stories and user feedback
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
<div class="col-md-12 row text-center">
	<br>
	<h1>User Feedback</h1>
	<br>
	<a href="#feedbackBreakdown" data-toggle="collapse">Show/Hide User Feedback Explanation</a>
  <div id="feedbackBreakdown" class="collapse in">
    <p>To assess the creativity of the system, I generated output for 3 cycles, with 4 different levels of constraints:</p>
		<div class="col-md-8 col-md-offset-2">
			<table class="table table-bordered table-hover">
				<tr><th></th><th>Action Choice</th><th>Event Choice</th><th>Location Choice</th><th>Respect Death</th><th>Allow Doppelgangers</th></tr>
				<tr><th>Tightly Constrained</th><td>Character Motivation</td><td>Markov</td><td>Markov</td><td>True</td><td>False</td></tr>
				<tr><th>Moderately Constrained (set 1)</th><td>Markov</td><td>Random</td><td>Random</td><td>True</td><td>False</td></tr>
				<tr><th>Moderately Constrained (set 2)</th><td>Markov</td><td>Markov</td><td>Random</td><td>True</td><td>False</td></tr>
				<tr><th>Unconstrained</th><td>Random</td><td>Random</td><td>Random</td><td>False</td><td>True</td></tr>
			</table>
		</div>
		<div class="row col-md-8 col-md-offset-2">
			<p>To see the stories evaluated and exactly how the questions were asked, click <a href="http://raptor.kent.ac.uk/~lam54/co880/UserEvaluation/index.html">here</a>.</p>
			<p>I then asked users to what extent they agreed the stories demonstrated creativity (with <a href="#definitions" data-toggle="collapse">these definitions</a> as a guide) and then asked if they liked the story. These two questions were designed to separate the users judgement about the creativity of the story from any other judgements about it's quality.</p>
			<div id="definitions" class="collapse">
				<blockquote>
					<p>The ability to produce original and unusual ideas, or to make something new or imaginative.</p>
					<footer><cite><a href="http://dictionary.cambridge.org/dictionary/english/creativity" target="_blank">Cambridge Dictionary</a></cite></footer>
				</blockquote>
				<br>
				<blockquote>
					<p>The ability to transcend traditional ideas, rules, patterns, relationships, or the like, and to create meaningful new ideas, forms, methods, interpretations, etc.; originality, progressiveness, or imagination.</p>
					<footer><cite><a href="http://www.dictionary.com/browse/creativity" target="_blank">Dictionary.com</a></cite></footer>
				</blockquote>
			</div>
			<p>Creativity was rated based on to what extent they agreed it was demonstrated using this scale:<br>
				Strongly Agree = 2<br>
				Agree = 1<br>
				Neutral = 0<br>
				Disagree = -1<br>
				Strongly Disagree = -2<br>
				This is converted into a chart below showing the average for each of the datasets.
			</p>
			<p><strong>The data presented below is an unfiltered overview of all responses and as such includes data from respondents who did not complete the entire feedback form.</strong></p>
		</div>
  </div>
</div>
<div class="col-md-12 row">
	<div class="col-md-6">
		<h4 class="text-center">Average Creativity Ratings</h4>
		<canvas id="avg-creativity-chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas>
	</div>
	<div class="col-md-6">
		<h4 class="text-center">Liked To Not Liked</h4>
		<h5 class="text-center">(By Dataset)</h5>
		<canvas id="like-dislike-chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas>
	</div>
</div>
<div class="col-md-12 row">
	<div class="col-md-6">
		<h4 class="text-center">Creativity Ratings</h4>
		<h5 class="text-center">(Totals)</h5>
		<canvas id="cnc-chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas>
	</div>
	<div class="col-md-6">
		<h4 class="text-center">Liked To Not Liked</h4>
		<h5 class="text-center">(Totals)</h5>
		<canvas id="like-dislike-total-chart" class="chartjs" width="1540" height="770" style="display: block; height: 385px; width: 700px;"></canvas>
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
