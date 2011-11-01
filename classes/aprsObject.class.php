<?php

class aprsObject extends aprsPosition {
	var $name;
	
	function getName() {
		return $this->name;
	}

	function setName($name) {
		$this->name = $name;
	}

	static function getRegexp() {
		return '/^;(.{9})\*(([0-9]{6}[hz])?([0-9]{4}\.[0-9]{2}[NS].[0-9]{5}\.[0-9]{2}[EW].))(.*)$/';
	}

	function _parseRawContent($skip=false, $matches=null) {
		parent::_parseRawContent(true);
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
				$this->setName(trim($matches[1]));
				$this->setTime($matches[3]);
				$this->setSympos($matches[4]);
				$this->setText($matches[5]);
	}

	function _generateRawPayload() {
		return sprintf(';%-9s*%s%s%s', $this->getName(), $this->getTime(), $this->getSympos(), $this->getText());	
	}
}
