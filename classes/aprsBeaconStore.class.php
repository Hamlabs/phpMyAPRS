<?php

// For now this class IS the interface definition :)

class aprsBeaconStore {

	private static $instance;

	// This class uses the specified folder to store files for all stored beacons, and filesystem timestamps to determine when things are due for beaconing.
	var $path;
	const ALL = false;
	const ONLY_DUE = true;
	
	function __construct($path) {
		$this->path = $path;
		if(file_exists($path)) {
			if(!is_dir($path)) throw new Exception(sprintf('%s: Specified path %s is not a directory', __METHOD__, $path));
		} else {
			mkdir($path);
		}
	}

	static function getInstance() {
		if(!$this->instance) {
			new aprsBeaconStore(aprsConfig::get('beaconstore', 'path'));
		}
		return $this->instance;
	}

	public function storeBeacon(aprsBeacon $beacon) {
		return file_put_contents($this->getFilenameForId($beacon->getId()), serialize($beacon));
	}
	
	public function deleteBeacon(aprsBeacon $beacon) {
		return unlink($this->getFilenameForId($beacon->getId()));
	}
	/* This bit of code is not needed, but kept just in case
	public function touchBeacon(aprsBeacon $beacon, $time=null, $atime=null) {
		return $this->touchBeaconId($beacon->getId(), $time=null, $atime=null);
	}

	public function touchBeaconId($beacon_id, $time=null, $atime=null) {
		return touch($this->getFilenameForId($beacon_id), $time, $atime);
	}
	*/

	public function getBeacon($beacon_id) {
		$filename = $this->getFilenameForId($beacon_id);
		if(file_exists($filename)) {
			return $this->getBeaconFromFile($filename);
		} else {
			return false;
		}
	}

	public function getBeaconFromFile($file) {
		return unserialize(file_get_contents($file));
	}
	
	public function getBeacons($only_due=false) {
		$ret = array();
		$dir = opendir($this->getPath());
		while($f = readdir($dir)) {
			if(!preg_match(sprintf('/^%s/', $this->getFilenamePrefix()), $f)) continue;
			$file = sprintf('%s/%s', $this->getPath(), $f);
			$beacon = $this->getBeaconFromFile($file);
			if(!$only_due || ($only_due && $beacon->isDue())) $ret[] = $beacon;
		}
		closedir($dir);
		return $ret;
	}

	/** Private functions **/

	private function getPath() {
		return $this->path;
	}

	private function getFilenamePrefix() {
		return 'aprsBeacon-';
	}

	private function getFilenameForId($beacon_id) {
		return sprintf('%s/%s%s', $this->getPath(), $this->getFilenamePrefix(), $beacon_id);
	}

	private function getBeaconFilenames($older_than=null) {
	
	}
		

}
