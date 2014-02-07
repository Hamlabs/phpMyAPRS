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

	private function login($callsign, $pass, $filter='') {
		$msg = sprintf('user %s pass %s vers %s', $callsign, $pass, aprsConfig::getVersion());
		if(!empty($filter)) $msg .= sprintf(' filter %s', $filter);
		$this->tx($msg);
	}

	function tx($msg) {
		$this->puts($msg);
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
			$this->tx($msg);
			usleep($txwait*1000);
		}
	}
	
	function executeBeaconSpooler() {
		$beaconstore = new aprsBeaconStore('/tmp/aprsbeacon');
		while(true) {
			sleep(1);
			foreach($beaconstore->getBeacons(aprsBeaconStore::ONLY_DUE) as $beacon) {
				printf("[%s]\t%s\n", $beacon->isDue() ? '*' : ' ', $beacon->getPacket());
				if($beacon->send()) {
					// If the send() method returns true, it needs to be saved
					$beaconstore->storeBeacon($beacon);
				}
			}
		}
	}

	function forkTransmitSpooler() {
		if(pcntl_fork()) {
			return true;
		} else {
			echo "TX process going!\n";
			$this->executeTransmitSpooler();
		}
	}

	function forkBeaconSpooler() {
		if(pcntl_fork()) {
			return true;
		} else {
			echo "BeaconSpooler process going!\n";
			$this->executeBeaconSpooler();
		}
	}

}

