<?php

class aprsObject extends aprsPosition {
	var $name;
	
	function getName() {
		return $this->name;
	}

	function setName($name) {
		$this->name = $name;
	}

	function _parseRawContent($skip=false) {
		// Sample payload
		// ";LA7F     *071835z6715.47N/01522.80E-LA7F Clubstation Fauskegruppen av NRRL"
		parent::_parseRawContent(true);
		if(!$skip) { 
			$matches = array();
			if(!preg_match('/^;(.{9})\*(([0-9]{6}[hz])?([0-9]{4}\.[0-9]{2}[NS].[0-9]{5}\.[0-9]{2}[EW].))(.*)$/', $this->getPayload(), $matches)) {
				printf("%s: Could not parse supposed object [%s]\n", __METHOD__, $this->getPayload());
			} else {
				$this->setName(trim($matches[1]));
				$this->setTime($matches[3]);
				$this->setSympos($matches[4]);
				$this->setText($matches[5]);
			}
		}
	}

	function _generateRawPayload() {
		return sprintf(';%-9s*%s%s%s', $this->getName(), $this->getTime(), $this->getSympos(), $this->getText());	
	}
}
