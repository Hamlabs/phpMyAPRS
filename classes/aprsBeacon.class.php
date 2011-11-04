<?php

class aprsBeacon {
	var $id;
	var $revision = 0;
	var $packet;
	var $last_beacon = 0;
	var $interval = 0;
	
	function __construct($id=null) {
		if(is_null($id)) $id = md5(microtime());
		$this->setId($id);
	}

	function setId($id) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}

	function setRevision($rev) {
		$this->revision = $rev;
	}

	function getRevision() {
		return $this->revision;
	}

	function setPacket($packet) {
		$this->packet = $packet;
	}

	function getPacket() {
		return $this->packet;
	}
	
	function setLastBeacon($time) {
		$this->last_beacon = $time;
	}

	function getLastBeacon() {
		return $this->last_beacon;
	}

	// Beacon interval in minutes
	function setInterval($interval) {
		$this->interval = $interval * 60;
	}

	function getInterval() {
		return $this->interval / 60;
	}

	// Returns true or false.
	// True if "interval" time has gone since last beacon.
	function isDue() {
		return $this->getLastBeacon() < (time() - $this->interval) ? true : false;
	}
}

