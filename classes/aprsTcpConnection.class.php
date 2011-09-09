<?php

class aprsTcpConnection {
	var $dbg;
	var $h;
	
	function __construct($host, $port, $debug=false) {
		$this->dbg = $debug;
		$this->h = fsockopen($host, $port);
		$this->debug("connection opened ($host:$port)");
	}
	
	function debug($str) {
		if(!$this->dbg) return;
		echo "TCP($this->h): $str\n";
	}
	
	function feof() {
		return feof($this->h);
	}
	
	function setblocking($bool) {
		return stream_set_blocking($this->h, $bool);
	}
	
	function get($d = false) {
		$k = fgets($this->h, 4096);
		if($d) echo $k;
		$this->debug("<- '$k'");
		return $k;
	}

	// non-blocking get
	function nbget($d = false) {
		if($this->feof()) return;
		return $this->get($d);
	}

	function getbuf() {
		$buf = '';
		while(!$this->feof()) {
			$buf .= $this->get();
		}
		return $buf;
	}
	
	function put($data) {
		$this->debug("-> '$data'");
		return fputs($this->h, $data);
	}
	
	function puts($string) {
		return $this->put($string."\r\n");
	}
	
	function close() {
		$this->debug('Connection closed.');
		return fclose($this->h);
	}	

	function isActive() {
		return $this->h;
	}
	
	function __destruct() {
		$this->close();
	}
}
