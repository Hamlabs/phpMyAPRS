<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');
date_default_timezone_set('Europe/Oslo');

$bs = new aprsBeaconStore('/tmp/aprsbeacon');

class vegvesen {
	static function getMessagesForCounty($county) {
		// Make 3 attempts at fetching the XML. if it doesn't work, die.
		for($c = 0; $c <= 2; $c ++) {
			$xml = file_get_contents('http://www.vegvesen.no/trafikk/xml/search.xml?searchFocus.counties='.$county);
			if(!$xml) {
				sleep(5);
				continue; 
			};
			if($xml) {
				$z = new SimpleXMLElement($xml);
				return $z->{'result-array'}->result->messages->message;
			}
		}
		return false;
	}
	
	static function filter($message) {
		// true if message is going to APRS-IS
		if($message->messageType == 'Vær- og føreforhold') return false;
		return true;
	}
	
	static function shorten($ingress) {
		$ret = array();
		$matches = array();
		if(preg_match('/på grunn av (\w+)/', $ingress, $matches)){
				$ret[] = $matches[1];
		}
		$matches = array();
		if(preg_match('/periodene: (\w+)dag til (\w+)dag fra (\d+):00 til (\d+):00/', $ingress, $matches)) {
				//periodene: Mandag til fredag fra 06:00 til 00:00 (neste dag)
				$ret[] = sprintf('%s-%s %02d-%02d', $matches[1], $matches[2], $matches[3], $matches[4]);
		}
		if(!count($ret)) {
			echo 'COULD NOT SHORTEN: '.$ingress."\n";
			return $ingress;
		}
		return implode(' ', $ret);
	}
	
	static function unspace($string) {
		return preg_replace('/\s+/','', $string);
	}

	static function beaconName($message) {
		return substr(vegvesen::unspace((string)$message->roadType.(string)$message->roadNumber.(string)$message->heading), 0, 9);	
	}

	static function beaconText($message) {
		return sprintf("%s: %s", (string)$message->messageType, vegvesen::shorten((string)$message->ingress));
	}

	static function fillBeacon($beacon, $message) {
		$obj = $beacon->getPacket();
    	$obj->setName(vegvesen::beaconName($message));
    	$obj->setText(vegvesen::beaconText($message));
    	$obj->setTime(aprsTime::now());
    	$beacon->setRevision((int)$message->version);
	}
}

$active = array();
foreach(vegvesen::getMessagesForCounty(18) as $message) {
	touch('../../vegvesen/meldingstyper/'.$message->messageType);
	if(!vegvesen::filter($message)) continue;
	$mid = (string)$message->messagenumber[0];
	$active[] = $mid;
	if($beacon = $bs->getBeacon($mid)) {
		// existing message
		if($message->version > $beacon->getRevision()) {
			echo "UPDATED BEACON\n";
			vegvesen::fillBeacon($beacon, $message);
			$beacon->setLastBeacon(0);
			$bs->storeBeacon($beacon);
			var_dump($obj);
		}
	} else {
		// new message
		echo "NEW BEACON\n";
		$beacon = new aprsBeacon($mid);
		$beacon->setInterval(30);
		$obj = new aprsObject();
		$beacon->setPacket($obj);
		vegvesen::fillBeacon($beacon, $message);
		$beacon->setLastBeacon(0);
		$bs->storeBeacon($beacon);
		var_dump($obj);
	}
}

foreach($bs->getBeacons() as $beacon) {
	if(!in_array($beacon->getId(), $active)) {
		echo "DELETE BEACON\n";
		// TODO: This really should have a way to TX the removal of the object as well...
		$bs->deleteBeacon($beacon);
	}
}
