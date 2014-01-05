#!/usr/bin/php
<?php
include dirname(__FILE__) . '/lib/functions.php';

// Get temperature (see http://www.raspberrypi.org/phpBB3/viewtopic.php?f=45&t=25100)
$temp = exec('/opt/vc/bin/vcgencmd measure_temp');
preg_match("/^temp=([\d.]+)/", $temp, $matches);

// Temperature is stored in at index 1.
$temp = $matches[1];
$date = new DateTime();
$filePath = realpath(dirname(__FILE__));
$ret = exec($filePath.'/update_plotly.py \''.$date->format('Y-m-d H:i:s').'\' '.$temp);
$line = $date->format(DateTime::ISO8601) . ";" . $temp . "\n";
// Write the temp to a file
$filePath = realpath(dirname(__FILE__));
file_put_contents(dirname(__FILE__) . '/temperature.log', $line, FILE_APPEND);

// Check if we should send a notification 
$config = getConfig();
$notificationConfig = $config['notification'];
$maxTemp = $notificationConfig['max_temp'];

if ((int)$temp >= $maxTemp) {
	// Temp is too high! Send notification!
	if ($notificationConfig['enable_email']) {
		$addresses = $notificationConfig['email_addresses'];
		sendEmailNotification($temp, $addresses);
	}
	
	if ($notificationConfig['enable_pushover']) {
		$userkey = $notificationConfig['pushover_userkey'];
		sendPushoverNotification($temp, $userkey);
	}
	
	if ($notificationConfig['enable_pushbullet']) {
		$deviceid = $notificationConfig['pushbullet_deviceid'];
		$apikey = $notificationConfig['pushbullet_apikey'];
		sendPushbulletNotification($temp, $deviceid, $apikey);
	}
}