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

	static function getSymbolTable($symbol) {
		return substr($symbol,0,1);
	}

	static function getSymbolCode($symbol) {
		return substr($symbol,1,1);
	}

	static function getAbsLatDegrees($geopos) {
		return floor(abs($geopos[0]));
	}

	static function getLatMinutesDec($geopos) {
		$dec = abs($geopos[0]) - self::getAbsLatDegrees($geopos);
		return $dec * 60;
	}

	static function getLatCardinal($geopos) {
		return $geopos[0] < 0 ? 'S' : 'N';
	}

        static function getAbsLonDegrees($geopos) {
                return floor(abs($geopos[1]));
        }

        static function getLonMinutesDec($geopos) {
                $dec = abs($geopos[1]) - self::getAbsLonDegrees($geopos);
                return $dec * 60;
        }

        static function getLonCardinal($geopos) {
                return $geopos[1] < 0 ? 'W' : 'E';
        }

	static function getRaw($symbol, $geopos) {
		return sprintf('%02d%05.2f%1s%1s%03d%05.2f%1s%1s',
			self::getAbsLatDegrees($geopos),
			self::getLatMinutesDec($geopos),
			self::getLatCardinal($geopos),
			self::getSymbolTable($symbol),
			self::getAbsLonDegrees($geopos),
			self::getLonMinutesDec($geopos),
			self::getLonCardinal($geopos),
			self::getSymbolCode($symbol)
		);
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
		$this->sympos = $this->latDeg . $this->latMin . "." .  $this->latMmm . $this->latNS . $this->symTable .
		$this->longDeg.$this->longMin . "." . $this->longMmm . $this->longEW. $this->symCode ;
		return true;		
	}

}
