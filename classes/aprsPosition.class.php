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

	static function getRegexp() {
		return '/^[\@\=\!\/]{1}(([0-9]{6}[hz])?([0-9]{4}\.[0-9]{2}[NS].[0-9]{5}\.[0-9]{2}[EW].))(.*)$/';
	}

	function _parseRawContent($skip=false, $matches=null) {
		parent::_parseRawContent(true); // FYI: Base class ignores parse skipping.
		if(!$skip) {
			if(empty($matches)) {
				$matches = array();
				if(!preg_match(self::getRegexp(), $this->getPayload(), $matches)) {
					printf("%s: Weird - Regexp does not match [%s]\n", __METHOD__, $this->getPayload());
					return;
				}
			}
			$this->_setFields($matches);
		}
	}

	function _setFields($matches) {
			$this->setTime($matches[2]);
			$this->setSympos($matches[3]);
			$this->setText($matches[4]);
	}

	function _generateRawPayload() {
		return sprintf('%s%s%s', $this->getTime(), $this->getSympos(), $this->getText());	
	}

}
