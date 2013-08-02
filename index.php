<?php 
// Get average functions and all that stuff
include 'lib/functions.php';

// Load the configuration
$config = getConfig();

// Load the temperature.log file
$temperatureFile = file_get_contents('temperature.log');

// Regex to capture format: 2013-07-22T21:30:01+0200;46.5
$regex = "/^((?:[0-9]{2,4}-?){3})T((?:[0-9]{2}:?){3}).*?;([0-9.]*$)/im";
preg_match_all($regex, $temperatureFile, $result);


// Prepare the values
$values = $result[3];
$floatValues = array();
foreach ($values as $value) {
	$floatValue = floatval($value);
	
	// Conversation to farenheit?
	if ($config['unit'] == 'f') {
		$floatValue = $floatValue * 9 / 5 + 32;	// Conversion to Farenheit
	}
	
	$floatValues[] = $floatValue;
}
$valuesLast24Hours = array_slice($floatValues, -96);
$valuesLastWeek = array_slice($floatValues, -96*7);

// Merge date and time part together
$labels = array_map(function($a, $b){
	$dateString = $a . ' ' . $b . ' UTC';
	return strtotime($dateString) * 1000;
}, $result[1], $result[2]);

// Create Points for Flot charting library
$points = array_map(function($a, $b){
	return array($a, $b);
}, $labels, $floatValues);

// Calculate average and min/max values
$average = average($floatValues);
$lowest = getMin($floatValues);
$highest = getMax($floatValues);

$average24Hours = average($valuesLast24Hours);
$lowest24Hours = getMin($valuesLast24Hours);
$highest24Hours = getMax($valuesLast24Hours);

$averageWeek = average($valuesLastWeek);
$lowestWeek = getMin($valuesLastWeek);
$highestWeek = getMax($valuesLastWeek);


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Raspberry Pi Monitor</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="refresh" content="900">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
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
     <h3>Last 24 Hours</h3>
     	<div id="day" style="height:300px" class="span9"></div>
     	<div class="span2 well">
     		<p>Average: <strong class="pull-right"><?php echo $average24Hours;?> C&deg;</strong></p>
     		<p>Lowest:	<strong class="pull-right"><?php echo $lowest24Hours?> C&deg;</strong></p>
     		<p>Highest: <strong class="pull-right"><?php echo $highest24Hours?> C&deg;</strong></p>
     	</div>
     </div>
     
     <div class="row">
     	<h3>Last Week</h3>
     	<div id="week" style="height:300px" class="span9"></div>
     	<div class="span2 well">
     		<p>Average: <strong class="pull-right"><?php echo $averageWeek;?> C&deg;</strong></p>
     		<p>Lowest:	<strong class="pull-right"><?php echo $lowestWeek?> C&deg;</strong></p>
     		<p>Highest: <strong class="pull-right"><?php echo $highestWeek?> C&deg;</strong></p>
     	</div>
     </div>
     
     <div class="row">
     	<h3>Overall</h3>
     	<div id="overall" style="height:300px" class="span9"></div>
     	<div class="span2 well">
     		<p>Average: <strong class="pull-right"><?php echo $average;?> C&deg;</strong></p>
     		<p>Lowest:	<strong class="pull-right"><?php echo $lowest?> C&deg;</strong></p>
     		<p>Highest: <strong class="pull-right"><?php echo $highest?> C&deg;</strong></p>
     	</div>
     </div>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.flot.min.js"></script>
    <script src="js/jquery.flot.time.min.js""></script>
    <script src="js/jquery.flot.tooltip.min.js""></script>

    <?php 
   	
    // Prepare the data
    $pointsDay = array_slice($points, -96);
    $pointsWeek = array_slice($points, -672);
    ?>
    
    <script type="text/javascript">
	$(document).ready(function() {
		var options = {
			xaxis: {
				mode: 	"time",
				format: "%d.%m.Y %H:%M"				
			},
			yaxis: {
				tickFormatter: function(value) {
					return value.toFixed(1) + ' <?php echo strtoupper($config['unit'])?>&deg;';
				}
			},
			grid: {
				hoverable: true,
				clickable: true,
			},
			tooltip: true,
			tooltipOpts: {
				content: "%y"
			}
		};

		var dataDay = [{
			color: "rgb(212,62, 48)",
			data: <?php echo json_encode($pointsDay);?>
		}];
		$.plot($("#day"), dataDay, options);

		var dataWeek = [{
			color: "rgb(212,62, 48)",
			data: <?php echo json_encode($pointsWeek);?>
		}];
		$.plot($("#week"), dataWeek, options);

		var dataOverall = [{
			color: "rgb(212,62, 48)",
			data: <?php echo json_encode($points);?>
		}];
		$.plot($("#overall"), dataOverall, options);
	});
    </script>
    
  </body>
</html>