<?php

class aprsPosition extends aprsBase {
	var $time;
	var $sympos;
	var $text;

	function getTime() {
		return $this->time;
	}

	function setTime($time) {
		$this->time = $time;
	}

	function getSympos() {
		return $this->sympos;
	}

	function setSympos($sympos) {
		$this->sympos = $sympos;
	}

	function getText() {
		return $this->text;
	}

	function setText($text) {
		$this->text = $text;
	}

	function _parseRawContent($skip=false) {
		// Sample payload
		// "!6246.73N/00714.92E#14.0V Molde, Tussen digi"
	
		// SJEKK spec side 22-27..
		// Har regex tatt hoyde for alterntive timestamps?

		parent::_parseRawContent();
		if(!$skip) {
			$matches = array();
			if(!preg_match('/^[\@\=\!\/](([0-9]{6}[hz])?([0-9]{4}\.[0-9]{2}[NS].[0-9]{5}\.[0-9]{2}[EW].))(.*)$/', $this->getPayload(), $matches)) {
				printf("%s: Could not parse supposed position [%s]\n", __METHOD__, $this->getPayload());
			} else {
				$this->setTime($matches[2]);
				$this->setSympos($matches[3]);
				$this->setText($matches[4]);
			}
		}
	}

	// Funksjonen er et alternativ til _parseRawContent for a fiske ut SymPos uten regex
	function _parseSymPos($data) {
		 
		$_latNr = substr($data, 0, 6);
		$_latNS = substr($data, 7, 7);
		$this->setPosLat = $_latNr . $latNS;
		unset($_latNr); unset($_latNS);

                $_longNr = substr($data, 9, 16);
                $_longNS = substr($data, 17, 17);
                $this->setPosLong = $_longNr . $longNS;
                unset($_longNr); unset($_longNS);

		$this->symbolTable = substr($data, 8, 8);
		$this->symbolCode  = substr($data, 18, 18);
	}

	function _generateRawPayload() {
		return sprintf('%s%s%s', $this->getTime(), $this->getSympos(), $this->getText());	
	}

}
