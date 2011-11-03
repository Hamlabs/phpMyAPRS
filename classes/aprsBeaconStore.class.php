<?php

// For now this class IS the interface definition :)

class aprsBeaconStore {
	// This class uses the specified folder to store files for all stored beacons, and filesystem timestamps to determine when things are due for beaconing.
	var $path;
	
	function __construct($path) {
		$this->path = $path;
		if(file_exists($path)) {
			if(!is_dir($path)) throw new Exception(sprintf('%s: Specified path %s is not a directory', __METHOD__, $path));
		} else {
			mkdir($path);
		}
	}

	public function storeBeacon(aprsBeacon $beacon) {
		return file_put_contents($this->getFilenameForId($beacon->getId()), serialize($beacon));
	}
	
	public function touchBeacon(aprsBeacon $beacon, $time=null, $atime=null) {
		return $this->touchBeaconId($beacon->getId(), $time=null, $atime=null);
	}

	public function touchBeaconId($beacon_id, $time=null, $atime=null) {
		return touch($this->getFilenameForId($beacon_id), $time, $atime);
	}

	public function getBeacon($beacon_id) {
		return $this->getBeaconFromFile($this->getFilenameForId($beacon_id));
	}

	public function getBeaconFromFile($file) {
		return unserialize(file_get_contents($file));
	}
	
	public function getBeacons($changed_after=null, $accessed_before=null) {
		$ret = array();
		$dir = opendir($this->getPath());
		while($f = readdir($dir)) {
			if(!preg_match(sprintf('/^%s/', $this->getFilenamePrefix()), $f)) continue;
			$file = sprintf('%s/%s', $this->getPath(), $f);
			$stat = stat($file);
			// TODO: Implement atime and mtime filtering here...
			$ret[] = $this->getBeaconFromFile($file);
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
