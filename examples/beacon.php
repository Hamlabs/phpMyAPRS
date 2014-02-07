<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');

$bs = new aprsBeaconStore('/tmp/aprsbeacon');

//$beacon = new aprsBeacon();
//$beacon->setLastBeacon(time());
//$beacon->setInterval(1);

//$bs->storeBeacon($beacon);

foreach($bs->getBeacons() as $beacon) {
	printf("[%4d]\t%s\n", $beacon->timeToNextBeacon(), $beacon->getPacket());
	//var_dump($beacon->getExponentialBackoff());

	//if(!$beacon->getExponentialBackoff() && $beacon->getInterval() < $beacon->getMaxInterval()) {
	//	echo "SET EXB!\n";
	//	$beacon->setExponentialBackoff(true);
	//	$bs->storeBeacon($beacon);
	//}
	//$bs->deleteBeacon($beacon);
}

