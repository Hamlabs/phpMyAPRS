<?php

class aprsCompressedPosition extends aprsPosition {

	var $comp;
	
	function getComp() {
		return $this->name;
	}

	function setComp($comp) {
		$this->comp = $comp;
	}

	static function getRegexp() {
		return '/^([\\!\\"\\#\\$\\%\\&\\\'\\(\\)\\*\\+\\,\\-\\.\\/\\0\\1\\2\\3\\4\\5\\6\\7\\8\\9\\:\\;\\<\\=\\>\\?\\@\\A\\B\\C\\D\\E\\F\\G\\H\\I\\J\\K\\L\\M\\N\\O\\P\\Q\\R\\S\\T\\U\\V\\W\\X\\Y\\Z\\[\\\\\\]\\^\\_\\`\\a\\b\\c\\d\\e\\f\\g\\h\\i\\j\\k\\l\\m\\n\\o\\p\\q\\r\\s\\t\\u\\v\\w\\x\\y\\z\\{]{13})(.*)$/';
		return '/^([ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789\\!\\#\\$\\%\\&\\(\\)\\*\\+\\,\\.\\/\\:\\;\\<\\=\\>\\?\\@\\[\\]\\^\\_\\`\\{\\|\\}\\~\\"]{13})(.*)$/';
	}

	function _parseRawContent($skip=false, $matches=null) {
		parent::_parseRawContent(true);
		if(!$skip) {
			if(empty($matches)) {
				$matches = array();
				if(!preg_match(self::getRegexp(), $this->getPayload(), $matches)) {
					printf("%s: Weird - Regexp does not match [%s]\\n", __METHOD__, $this->getPayload());
					return;
				}
			}
			$this->_setFields($matches);
		}
	}

	function _setFields($matches) {
				$this->setComp($matches[1]);
				$this->setText($matches[2]);
	}
	
	
	

	function _enCode($matches) {
				$this->setComp($matches[1]);
				$this->setText($matches[2]);
	}

	function _deCode() {
	
        /*
        This function need $this-comp to be set to a valid 13 char string
        Depending on the contents of $this-comp it will set some of the following vars
        
          $this->latDeComp
          $this->longDeComp
          $this->range
          $this->altitude
          $this->course
          $this->speed
          
        Function depends on aprsConverter class to correctly reformat lat/long
        */

        // Slice'n Dice (ref. aprs 101, page 37)
        $this->symbol = $this->comp[0].$this->comp[9];
        $y1 = ord($this->comp[1]) - 33;
        $y2 = ord($this->comp[2]) - 33;
        $y3 = ord($this->comp[3]) - 33;
        $y4 = ord($this->comp[4]) - 33;
        $x1 = ord($this->comp[5]) - 33;
        $x2 = ord($this->comp[6]) - 33;
        $x3 = ord($this->comp[7]) - 33;
        $x4 = ord($this->comp[8]) - 33;
        $c  = ord($this->comp[10])- 33;
        $s  = ord($this->comp[11])- 33;
        $T  = ord($this->comp[12])- 33;
        
        // Lat/Long Decoding
        $this->latDeComp  = aprsConverter::ddd2dmm(  90 - ($y1*(91^3) + $y2*(91^2) + $y3*(91^1) + $y4) / 380926 );
        $this->longDeComp = aprsConverter::ddd2dmm(-180 + ($x1*(91^3) + $x2*(91^2) + $x3*(91^1) + $x4) / 190463 );
        
        
        // The Compression Type (T) Byte
        $tBinary = decbin($T);
        if(strlen($tBinary) <> 8 ) {
          echo "This fucking fuck is fucking fucked";
                exit;
        } else {
          $origin = substr($tBinary,0,3);
          $source = substr($tBinary,3,2);
          $fix    = substr($tBinary,5,1);
        }
        
        // T byte format (for future use)
        $tFormat = array(
          "origin" => array(
            "000" => "Compressed",
            "001" => "TNC BText",
            "010" => "Software (DOS/Mac/Win/+SA)",
            "011" => "[tbd]",
            "100" => "KPC3",
            "101" => "Pico",
            "110" => "Other tracker [tbd]",
            "111" => "Digipeater conversion"
          ),
          "source" => array(
            "00" => "other",
            "01" => "GLL",
            "10" => "GGA",
            "11" => "RMC"
          ),
          "fix" => array(
            "0" => "old (last)",
            "1" => "current"
          )
        );
        
        // Course/Speed, Pre-Calculated Radio Range and Altitude
        if($c == 32) { // If c == space, there's no aditional data in csT
          exit;
        } else
        
        if($source == "10") { // GGA sentence, cs == altitude
          $this->altitude = 1.002^((91*$c)+$s);  // feet
        } else
        
        if($c == 90) { // If c == {, s == Pre-Calculated Radio Range
          $this->range = 2*(1.08^$s); // miles
        } else
        
        if($c <= 89 || $c >= 0) {
          $this->course = 4*$c;          // degrees
          $this->speed  = ( 1.08^$s ) – 1; // Knots
        } else {
        
        // All failed, something is wrong!
        echo "This fucking fuck is fucking fucked";
             exit;
        }
  }

	function _generateRawPayload() {
		return sprintf(';%-9s*%s%s%s', $this->getTime(), $this->getComp(), $this->getText());	
	}
}
