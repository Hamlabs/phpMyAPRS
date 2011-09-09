<?php

class aprsIsConnection extends aprsTcpConnection {

	var $callsign = "";

	function __construct($host, $port, $callsign, $pass, $filter, $debug=false) {
		// create connection
		parent::__construct($host, $port, $debug);

		$this->callsign = $callsign;

		// log in to server
		$this->login($callsign, $pass, $filter);
	}

	function login($callsign, $pass, $filter) {
		$msg = sprintf('user %s pass %s vers phpMyAPRS 0.0.1 filter %s', $callsign, $pass, $filter);
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
