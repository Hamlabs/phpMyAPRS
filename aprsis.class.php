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
			case preg_match('/^;[A-Za-z0-9_\ ]{9}\*/', $split[1]):
				return aprsObject::dispatch($raw);
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
	
	function getRawContent() {
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
		return sprintf('%s>%s', $this->sender, implode(',', $this->path));
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

	function getPayload() {
		return $this->contents;
	}

	function setPayload($contents) {
		$this->contents = $contents;
	}
}

class aprsPosition extends aprsBase {
	var $time;
	var $sympos;
	var $text;

	function getTime() {
		return $this->time;
	}

	function setTime($time) {
		$this->time = $time;
	}

	function getSympos() {
		return $this->sympos;
	}

	function setSympos($sympos) {
		$this->sympos = $sympos;
	}

	function getText() {
		return $this->text;
	}

	function setText($text) {
		$this->text = $text;
	}

	function _parseRawContent($skip=false) {
		// Sample payload
		// "!6246.73N/00714.92E#14.0V Molde, Tussen digi"
		parent::_parseRawContent();
		if(!$skip) {
			$matches = array();
			if(!preg_match('/^[\@\=\!\/](([0-9]{6}[hz])?([0-9]{4}\.[0-9]{2}[NS].[0-9]{5}\.[0-9]{2}[EW].))(.*)$/', $this->getPayload(), $matches)) {
				printf("%s: Could not parse supposed position [%s]\n", __METHOD__, $this->getPayload());
			} else {
				$this->setTime($matches[2]);
				$this->setSympos($matches[3]);
				$this->setText($matches[4]);
			}
		}
	}

	function _generateRawPayload() {
		return sprintf('%s%s%s', $this->getTime(), $this->getSympos(), $this->getText());	
	}

}

class aprsObject extends aprsPosition {
	var $name;
	
	function getName() {
		return $this->name;
	}

	function setName($name) {
		$this->name = $name;
	}

	function _parseRawContent($skip=false) {
		// Sample payload
		// ";LA7F     *071835z6715.47N/01522.80E-LA7F Clubstation Fauskegruppen av NRRL"
		parent::_parseRawContent(true);
		if(!$skip) { 
			$matches = array();
			if(!preg_match('/^;(.{9})\*(([0-9]{6}[hz])?([0-9]{4}\.[0-9]{2}[NS].[0-9]{5}\.[0-9]{2}[EW].))(.*)$/', $this->getPayload(), $matches)) {
				printf("%s: Could not parse supposed object [%s]\n", __METHOD__, $this->getPayload());
			} else {
				$this->setName(trim($matches[1]));
				$this->setTime($matches[3]);
				$this->setSympos($matches[4]);
				$this->setText($matches[5]);
			}
		}
	}

	function _generateRawPayload() {
		return sprintf(';%-9s*%s%s%s', $this->getName(), $this->getTime(), $this->getSympos(), $this->getText());	
	}
}

class aprsStatus extends aprsBase {
}

class aprsMessage extends aprsBase {
}

