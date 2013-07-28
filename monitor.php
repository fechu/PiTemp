#!/usr/bin/php
<?php
// Get temperature (see http://www.raspberrypi.org/phpBB3/viewtopic.php?f=45&t=25100)
$temp = exec('/opt/vc/bin/vcgencmd measure_temp');
preg_match("/^temp=([\d.]+)/", $temp, $matches);

// Temprature is stored in at index 1.
$temp = $matches[1];
$date = new DateTime();
$line = $date->format(DateTime::ISO8601) . ";" . $temp . "\n";
// Write the temp to a file
$filePath = realpath(dirname(__FILE__));
file_put_contents('/var/www/monitor/temperature.log', $line, FILE_APPEND);
