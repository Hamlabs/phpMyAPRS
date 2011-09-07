<?php

class aprsIs extends tcp {

	var $callsign = "";

	function __construct($host, $port, $callsign, $pass, $filter, $debug=false) {
		// create connection
		parent::__construct($host, $port, $debug);

		$this->callsign = $callsign;

		// log in to server
		$this->login($callsign, $pass, $filter);
	}

	function login($callsign, $pass, $filter) {
		$msg = sprintf('user %s pass %s vers phpAPRS-IS 0.0.1 filter %s', $callsign, $pass, $filter);
		$this->puts($msg);
	}

	function tx($msg, $dest='APZ001') {
		$this->puts(sprintf("%s>%s:%s", $this->callsign, $dest, $msg));
	}

	function rx() {
		while($rx = trim($this->get())) {
			if($ret = aprsObjectDispatcher::dispatch($rx)) return $ret;
		}
	}

}

class aprsObjectDispatcher {
	static function dispatch($raw) {
		$split = explode(':', $raw, 2);
		if(substr($raw, 0, 1) == '#') return false; // Comment lines from APRS-IS are ignored
		var_dump(substr($split[1], 0, 1));
		switch(true) {
			case substr($split[1], 0, 1) == '@':
			case substr($split[1], 0, 1) == '=':
			case substr($split[1], 0, 1) == '!':
			case substr($split[1], 0, 1) == '/':
				return aprsPosition::dispatch($raw);
			case substr($split[1], 0, 1) == '>':
				return aprsStatus::dispatch($raw);
			default:
				return aprsStatus::dispatch($raw);
		}
	}
	
	// Er ikke sikker pŒ hvordan jeg vil l¿se dette...
	static function old_dispatch($raw) {
		$match = array();
		switch(true) {
			case preg_match('/^[A-Z0-9]+(-[0-9]+)?\>[a-zA-Z0-9\-\*,]+\:/', $raw, $match):
				var_dump($match);
				return aprsMessage::dispatch($raw);
			default:
				printf("%s: Could not dispatch [%s]\n", __METHOD__, $raw);
				return false;
		}
	}
}

class aprsBase {
	var $raw;
	var $sender;
	var $path = array();
	var $contents;
	
	function __construct() {
	
	}
	
	function setRawContent($raw) {
		$this->raw = $raw;
		$this->_parseRawContent();
	}
	
	function getRawContent($raw) {
		return $this->raw;
	}

	function _parseRawContent() {
		$a = explode('>', $this->raw, 2);
		$this->sender = $a[0];
		$b = explode(':', $a[1], 2);
		$this->contents = $b[1];
		$this->path = explode(',', $b[0]);
	}

	function _generateRawContent() {
		$this->raw = sprintf('%s>%s:%s', $this->sender, implode(',', $this->path), $this->contents);
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
		$this->sender = sender;	
	}

	function getPath() {
		return $this->path;
	}

	function setPath(array $path) {
		$this->path = $path;
	}

	function addPathHop($hop) {
		$this->path[] = $hop;
	}

	function getContents() {
		return $this->contents;
	}

	function setContents($contents) {
		$this->contents = $contents;
	}
}

class aprsStatus extends aprsBase {
}

class aprsMessage extends aprsBase {
}

class aprsPosition extends aprsBase {
}
