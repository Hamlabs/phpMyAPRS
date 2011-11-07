<?php

class aprsCompressedPosition extends aprsPosition {

	var $symposcomp;
	
	function getSymPosComp() {
		return $this->symposcomp;
	}

	function setSymPosComp($symPosComp) {
		$this->symposcomp = $symPosComp;
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
				$this->getSymPosComp($matches[1]);
				$this->setText($matches[2]);
	}
	
	
		function _generateRawPayload() {
		return sprintf(';%-9s*%s%s%s', $this->getTime(), $this->getComp(), $this->getText());	
	}
}
