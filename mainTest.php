<!DOCTYPE html>
<html>
<!-- Presents a button to generate stories and some information on the state of the knowledge base (retrieved from storydata.php) -->
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
	<!-- Initialise tooltips -->
	<script>
		$(document).ready(function(){
		    $('[data-toggle="tooltip"]').tooltip();
		});
	</script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Main Test CO880</title>
</head>
<!-- onload function should be setup that calls the setup function in main.php -->
<body onload="mainSetup();">
	<div id="mainBody" class="col-md-12 text-center">
		<h1>CO880 Main Test</h1>
		<div id="storyParams" class="form-group">
			<!--  Params returned here by mainSetup() -->
		</div>
	 	<br>
		<div>
			<a class='btn btn-default' onclick="getStory();">Test!</a><br><br>
			<!-- View the passed parameters and returned data  -->
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#paramsModal">View Params</button><br><br>
		</div>
		<div id="outlineBox" class=".col-md-8 .col-md-offset-4"></div></br>
	</div>



	<!-- Modals -->
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
