<?php

class aprsSymPos {
	var $time;
	var $sympos;
	var $text;

	function getSymbol() {
    if( !empty($this->symbolTable) && !empty($this->symbolCode) ) {
      return getSymbolTable().getSymbolCode();
		} else {
      return false;
		}
	}

	function setSymbol($data) {
		setSymbolTable($data[0]);
		setSymbolCode($data[1]);
	}


	function getSymbolTable() {
    return $this->symbolTable;
  }

  function setSymbolTable($data) {
    $this->symbolTable = $data;
  }

  function getSymbolCode() 
    return $this->symbolCode;
  }

  function setSymbolCode($data) {
    $this->symbolCode = $data;
  }

 /*
	function getLatLong() {
    return $this->latLong;
	}

  function setLatLong($data) {
    $this->latLong = $data;
  }
 */
 
  function getLatitude() {
    return $this->latitude;
  }

  function setLatitude($data) {
    $this->latitude = $data;
  }

	function getLongitude() {
    return $this->longitude;
  }

  function setLongitude($data) {
    $this->longitude = $data;
  }


  function getSymPos() {
    _createSymPos();
    return $this->symPos;
  }

  function setSymPos($data) {
    _parseSymPos($data);
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
		
		$this->symPos = $this->latDeg . $this->latMin . "." .  $this->latMmm . $this->latNS . $this->symTable \
    $this->longDeg.$this->longMin . "." . $this->longMmm . $this->longEW. $this->symCode ;

		return true;		
	}

}
