<?php

/**
 * Merges the application and the local config and returns it.
 */
function getConfig()
{
	$config = include 'config.php';
	if (file_exists('local.config.php')) {
		// Load the local config an merge
		$localConfig = include 'local.config.php';
		$config = array_merge($config, $localConfig);
	}
	
	return $config;
}

/**
 * Calculates the average of the given values
 */
function average($values) {
	$total = 0;
	$count = 0;
	foreach ($values as $temperature) {
		$total += $temperature;
		$count++;
	}
	
	return number_format(round($total / $count, 1), 1);
}

/**
 * @return the minimum value in an array of integers.
 */
function getMin($values) {
	$lowest = NULL;
	foreach ($values as $temperature) {
		$value = $temperature;
		if ($lowest === NULL || $value < $lowest) {
			$lowest = $value;
		}
	}
	return number_format($lowest, 1);
}

/**
 * @return the maximum value in an array of integers
 */
function getMax($values) {
	$highest = NULL;
	foreach ($values as $temperature) {
		$value = $temperature;
		if ($highest === NULL || $value > $highest) {
			$highest = $value;
		}
	}
	return number_format($highest, 1);
}

/**
 * Sends a notification email to the email address defined 
 * in the configuration file.
 * If no email address is defined, this method files silently.
 * @param $temp The measured temperature
 * @param $addresses The addresses you want to send an email to.
 */
function sendEmailNotification($temp, $addresses = array())
{
	$to = join(",", $addresses);
	$subject = "PiTemp Notification";
	$message = "Your RaspberryPi's temperature raised above your defined maximum temperature.\r\n\r\n" .
			"Current temperature is " . $temp . "C";
	$headers = "From: PiTemp <notification@pitemp.local> \r\n";
	
	// Send the mail!
	var_dump(mail($to, $subject, $message, $headers));
}