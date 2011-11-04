<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');

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
}

foreach(vegvesen::getMessagesForCounty(18) as $message) {
	if(!vegvesen::filter($message)) continue;
	echo $message->messagenumber."-".$message->version." ";
	echo $message->roadType.$message->roadNumber.": ".$message->heading."\n";;
	echo $message->messageType.": ";
	echo $message->ingress."\n";
	echo "\n";	
	//var_dump($message);
}
