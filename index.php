<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Raspberry Pi Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
      .container-canvas {
      	margin-right:auto;
      	margin-left:auto;
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
    <![endif]-->

  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">Raspberry Pi</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Temperature</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

     <div class="row">
     	<div class="span12 container-canvas">
     	<h3>Last 24 Hours</h3>
	     	<center>
     			<canvas id="last24Hour" width="1000" height="400"></canvas>
     		</center>
     	</div>
     </div>
     
     <div class="row">
     	<div class="span12 container-canvas">
     	<h3>Last Week</h3>
	     	<center>
     			<canvas id="week" width="1000" height="400"></canvas>
     		</center>
     	</div>
     </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js""></script>

    <?php 
    	
    /**
     * 
     * 
     */
    function arrayReplaceObjects($array, $position) 
   	{
   		$i = 0;
   		foreach ($array as $object) {
   			if ($i % $position) {
   				$array[$i] = "";
   			}
   			$i++;
   		}	
   		return $array;
   	}
   
   	// Load the temperature.log file
   	$temperatureFile = file_get_contents('temperature.log');
   	// Regex to capture format: 2013-07-22T21:30:01+0200;46.5
   	$regex = "/^((?:[0-9]{2,4}-?){3})T((?:[0-9]{2}:?){3}).*?;([0-9.]*$)/im";
   	
   	preg_match_all($regex, $temperatureFile, $result);
   	
   	// Last 24 Hours
   	$labelsLast24Hours = array_slice($result[2], -96);
   	$labelsLast24Hours = arrayReplaceObjects($labelsLast24Hours, 4);
   	$valuesLast24Hours = array_slice($result[3], -96);
   	
   	// Last Week
   	$labelsLastWeek = array_slice($result[1], -96*7);
   	$labelsLastWeek = arrayReplaceObjects($labelsLastWeek, 96);
   	$valuesLastWeek = array_slice($result[3], -96*7);
   	
    ?>
    
    <script type="text/javascript">
	$(document).ready(function() {
		var ctx24Hours = $("#last24Hour").get(0).getContext("2d");
		var chart24Hours = new Chart(ctx24Hours);

		var ctxWeek = $("#week").get(0).getContext("2d");
		var chartWeek = new Chart(ctxWeek);		

		var data24Hours = {
			labels : <?php echo json_encode($labelsLast24Hours); ?>, 
			datasets : [
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : <?php echo json_encode($valuesLast24Hours);?>
				},
			]
		};

		var dataWeek = {
			labels : <?php echo json_encode($labelsLastWeek); ?>,
			datasets : [
				{
					fillColor : "rgba(151,187,205,0.5)",
					strokeColor : "rgba(151,187,205,1)",
					pointColor : "rgba(151,187,205,1)",
					pointStrokeColor : "#fff",
					data : <?php echo json_encode($valuesLastWeek);?>
				},
			]
		};		
		var options = {
			scaleOverride : true,
			scaleSteps : 20,
			scaleStepWidth :0.5,
			scaleStartValue: 40,
			scaleLabel : "<%=value%> C",
			pointDot : false,
		};

		chart24Hours.Line(data24Hours, options);
		chartWeek.Line(dataWeek, options);
	});
    </script>
    
  </body>
</html>