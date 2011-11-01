<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');

// Set up APRS-IS connection
$aprs = new aprsIsConnection();

if(pcntl_fork()) {
	echo "RX process going!\n";
	// Parent process.. Receives APRS traffic
	while($rx = $aprs->rx()) {
		echo ".";
		//echo "RX: ";
		//var_dump($rx);
	}
} else {
	echo "TX process going!\n";
	// Child process.. takes care of pushing data out.
	$aprs->executeTransmitSpooler();
}

