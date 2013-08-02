<?php 

return  array(
	
	/**
	 * Defines wheter to display the temperature in degrees farenheit or degrees celsius. 
	 * 
	 * Values: 
	 *  "c" 	Ceslius
	 *  "f"		Farenheit
	 */
	"unit" => "c",
	
	
	/**
	 * Contains settings for notifications
	 */
	"notification" => array(
		
		
		/**
		 * The maximum temperature of the Pi. If the temperature raises 
		 * above this level, a notification will be sent. 
		 */
		'max_temp' => 50.0,
		
		
		/**
		 * Enable email notifications. 
		 * Keep in mind that you have to set the email_address
		 * too. Otherwise you won't get any email.
		 */
		'enable_email' => false,
		
		/**
		 * An array of all email addresses that should receive an email notification 
		 * when the temperature is raised too high.
		 */
		'email_addresses' => array(
			'email@you.com',
		),
		

		/**
		 * Enable notifications with Pushover.
		 * Take a look at http://pushover.net if you don't know that service.
		 * You just need to download their application and signup. 
		 */
		'enable_pushover' => false,
		
		/**
		 * Drop in your userkey from Pushover. This one is used for sending messages
		 * to your devices.
		 */
		'pushover_userkey' => 'YOUR_USER_KEY',
	),
	
	/**
	 * The instance of PiTemp Server. 
	 * At the moment the PiTemp Server is only used to deliver Pushover notifications
	 * to Pushover.net. It's a way to hide our Pushover application key. 
	 * If you want to use your own instance you can get it from 
	 * https://github.com/fechu/PiTemp-Server.git. Installation instructions are also 
	 * available on github. Once you have your setup configured just drop in 
	 * the URL to the pushover.php file in the root directory of PiTemp Server. 
	 */
	'pi_temp_server' => 'http://pitemp.fidelisfactory.ch/pushover.php',
);