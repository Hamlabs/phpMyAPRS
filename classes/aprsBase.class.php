<?php

class aprsBase {
	var $raw;
	var $sender;
	var $path = array();
	var $destination;
	var $contents;
	
	function __construct() {
		$this->setDestination(aprsConfig::getAX25dst());
	}
	
	function setRawContent($raw, $matches=null) {
		$this->raw = $raw;
		$this->_parseRawContent(false, $matches);
	}
	
	function getRawContent() {
		//if(empty($this->raw)) 
		$this->_generateRawContent();
		return $this->raw;
	}

	function __toString() {
		return $this->getRawContent();
	}

	function _parseRawContent($skip=false) {
		$a = explode('>', $this->raw, 2);
		$this->sender = $a[0];
		$b = explode(':', $a[1], 2);
		$this->contents = $b[1];
		$this->path = explode(',', $b[0]);
	}

	function _generateRawContent() {
		$this->raw = sprintf('%s:%s', $this->_generateRawHeader(), $this->_generateRawPayload());
	}

	function _generateRawHeader() {
		return sprintf('%s>%s,%s', $this->sender, $this->destination, implode(',', $this->path));
	}

	function _generateRawPayload() {
		return $this->contents;
	}

	static function dispatch($raw) {
		$class = get_called_class();
		$ret = new $class();
		$ret->setRawContent($raw);
		return $ret;
	}

	function getSender() {
		return $this->sender;	
	}

	function setSender($sender) {
		$this->sender = $sender;	
	}

	function getPath() {
		return $this->path;
	}

	function setPath(array $path) {
		$this->path = $path;
	}

	function getDestination() {
		return $this->destination;
	}

	function setDestination($destination) {
		$this->destination = $destination;
	}

	function addPathHop($hop) {
		$this->path[] = $hop;
	}

	function getPayload() {
		return $this->contents;
	}

	function setPayload($contents) {
		$this->contents = $contents;
	}
	
	function isSendable() {
		// insert sensible logic here...
		return true;	
	}
	
	function send() {
		$this->setSender(aprsConfig::get('aprsis', 'callsign'));
		$this->setPath(array('TCPIP*'));
		if($this->isSendable()) {
			$q = aprsConfig::getQueue();
			echo "TO QUEUE: ".$this->getRawContent()."\n";
			$q->put($this->getRawContent());
			return true;
		} else {
			return false;
		}
	}
}
