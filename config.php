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
);