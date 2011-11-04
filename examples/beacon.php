<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');

$bs = new aprsBeaconStore('/tmp/aprsbeacon');

$beacon = new aprsBeacon();
$beacon->setLastBeacon(time());
$beacon->setInterval(1);

//$bs->storeBeacon($beacon);

foreach($bs->getBeacons(aprsBeaconStore::ONLY_DUE) as $beacon) {
	var_dump($beacon);
	$bs->deleteBeacon($beacon);
}

