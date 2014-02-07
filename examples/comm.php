<?php

echo "boot...";
require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');
echo "done.\n";

echo "APRS-IS...";
// Set up APRS-IS connection
$aprs = new aprsIsConnection();
echo "done.";

echo "fork tx...\n";
$aprs->forkTransmitSpooler();

echo "fork beacon...\n";
$aprs->forkBeaconSpooler();

echo "rx...\n";
while($rx = $aprs->rx()) {
	echo ".";
	//echo "RX: ";
	//var_dump($rx);
}
