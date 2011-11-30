<?php

class aprsSymPos {
	var $symbol;
	var $sympos;
	var $text;


	function getSymbol() {
		return $this->symbol;
	}

	function setSymbol($data) {
		$this->symbol = $data;
	}

	function getGeoPos() {
	    return $this->geopos;
	}
	
	function setGeoPos($data) {
		$this->geopos = $data;
	}

	function getSymPos() {
		_createSymPos();
		return $this->sympos;
	}

	function setSymPos($data) {
    	$this->sympos = $data;
		_parseSymPos($data);
	}

	static function getRaw($symbol, $position) {
		
	}

	// Disect sympos into smaler chunks
	// SymPos eks. from _praseRawData: 6246.73N/00714.92E#
	// 
	function _parseSymPos($data) {
	
    if( !is_num($data[0]) ) { // If first char is a number, the string is not compressed
		 
      $this->latDeg  = substr($data, 0, 1);
      $this->latMin  = substr($data, 2, 3);
      $this->latMmm  = substr($data, 5, 6);
      $this->latNS   = substr($data, 7, 7);

      $this->longDeg = substr($data, 9, 11);
      $this->longMin = substr($data, 12, 13);
      $this->longMmm = substr($data, 15, 16);
      $this->longEW  = substr($data, 17, 17);

      $this->symbolTable = substr($data, 8, 8);
      $this->symbolCode  = substr($data, 18, 18);
		} else {
      # goto compressed version and try there ...
		}
	}


	function _createSymPos() {
		$this->sympos = $this->latDeg . $this->latMin . "." .  $this->latMmm . $this->latNS . $this->symTable \
		$this->longDeg.$this->longMin . "." . $this->longMmm . $this->longEW. $this->symCode ;
		return true;		
	}

}
