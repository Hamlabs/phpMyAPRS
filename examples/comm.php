<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');

// Set up APRS-IS connection
$aprs = new aprsIsConnection();

$aprs->forkTransmitSpooler();

while($rx = $aprs->rx()) {
	echo ".";
	//echo "RX: ";
	//var_dump($rx);
}
