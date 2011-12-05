<?php

class aprsBeacon {
	var $id;
	var $revision = 0;
	var $packet;
	var $last_beacon = 0;
	var $interval = 0;
	var $tx_count = 0;
	var $max_tx_count = 0;
	var $exp_backoff = false;
	
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

	// Beacon interval in seconds
	function setInterval($interval) {
		$this->interval = $interval;
	}

	function getInterval() {
		return $this->interval;
	}

	function setTxCount($count) {
		$this->tx_count = $count;
	}

	function increaseTxCount() {
		$this->tx_count ++;
	}

	function getTxCount() {
		return $this->tx_count;
	}

	function setMaxTxCount($count) {
		$this->max_tx_count = $count;
	}

	function getMaxTxCount() {
		return $this->max_tx_count;
	}

	function getExponentialBackoff() {
		return $this->exp_backoff;
	}

	function putExponentialBackoff($bool) {
		$this->exp_backoff = $bool;
	}

	// Returns true or false.
	// True if "interval" time has gone since last beacon.
	function isDue() {
		if( $this->getLastBeacon() < (time() - $this->interval)) {
			if($this->getMaxTxCount()) {
				return $this->getTxCount() < $this->getMaxTxCount() ? true : false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	
	private function registerTx() {
		// Take care of the internal things that must happen when the beacon is sent.

		// Register time of beaconing
		$this->setLastBeacon(time());

		// Increate tx counter
		$this->increaseTxCount();
		
		// Increate interval if exponential backoff beacon
		if($this->getExponentialBackoff()) {
			$this->setInterval($this->getInterval() * 2);
		}
		
		// TODO: This method could also in the future fire a registered callback when a beacon is deprecated.
	}
}

