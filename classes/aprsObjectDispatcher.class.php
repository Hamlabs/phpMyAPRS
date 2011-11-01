<?php

class aprsObjectDispatcher {
	var $regexp = array();
	
	function __construct() {
		// initialize dispatcher by fetching match rules from all classes
		foreach($this->getPayloadClasses() as $class) {
			$this->regexp[$class] = $class::getRegexp();
		}
	}

	function getPayloadClasses() {
		return array(
			'aprsObject',
			'aprsPosition',
			'aprsCompressedPosition',
		);
	}

	function dispatch($raw) {
		$split = explode(':', $raw, 2);
		if(substr($raw, 0, 1) == '#') return false; // Comment lines from APRS-IS are ignored
		$matches = array();
		foreach($this->regexp as $class=>$rule) {
			if(preg_match($rule, $split[1], $matches)) {
				//printf("%s: Matched regexp for %s to [%s]\n", __METHOD__, $class, $raw);
				return $class::dispatch($raw, $matches);
			}
		}
		printf("%s: Cannot dispatch object for packet [%s]\n", __METHOD__, $raw);
		printf("%s: Last tried was for %s and came up with:", __METHOD__, $class);
		var_dump($matches);
		return false;
	}
	
}
