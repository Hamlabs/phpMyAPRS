<?php

class aprsIsConnection extends aprsTcpConnection {

	var $callsign = null;

	function __construct() {
		// create connection
		parent::__construct(
			aprsConfig::get('aprsis', 'server'),
			aprsConfig::get('aprsis', 'port')
		);

		$this->callsign = aprsConfig::get('aprsis', 'callsign');

		// log in to server
		$this->login(
			$this->callsign, 
			aprsConfig::get('aprsis', 'passcode'), 
			aprsConfig::get('aprsis', 'filter')
		);
	}

	private function login($callsign, $pass, $filter) {
		$msg = sprintf('user %s pass %s vers phpMyAPRS 0.0.1 filter %s', $callsign, $pass, $filter);
		$this->puts($msg);
	}

	function tx($msg, $dest='APZ001') {
		$this->puts(sprintf("%s>%s:%s", $this->callsign, $dest, $msg));
	}

	function rx() {
		$d = new aprsObjectDispatcher();
		
		while($rx = trim($this->get())) {
			if($ret = $d->dispatch($rx)) return $ret;
		}
	}

	function executeTransmitSpooler() {
		$txwait = aprsConfig::get('aprsis', 'tx-wait');
		$queue = aprsConfig::getQueue();

		while($msg = $queue->get()) {
			echo "TX: $msg\n";
			$this->puts($msg);
			usleep($txwait*1000);
		}
	}

}

