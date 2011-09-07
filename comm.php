<?php

require_once('autoload.php');

// Set up APRS-IS connection
$ac = $__CONF['aprsis'];
$aprs = new aprsis($ac['server'], isset($ac['port'])?$ac['port']:'14580', $ac['callsign'], $ac['passcode'], $ac['filter']);

if(pcntl_fork()) {
	echo "RX process going!\n";
	// Parent process.. Receives APRS traffic
	while($rx = $aprs->rx()) {
		echo "RX: ";
		var_dump($rx);
	}
} else {
	echo "TX process going!\n";
	// Child process.. takes care of pushing data out.
	while(1) {
		//echo "TX: nothing to do\n";
		usleep($ac['tx-wait']*1000);
	}
}

