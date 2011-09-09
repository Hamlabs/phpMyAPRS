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

	function _generateRawPayload() {
		return sprintf('%s%s%s', $this->getTime(), $this->getSympos(), $this->getText());	
	}

}
