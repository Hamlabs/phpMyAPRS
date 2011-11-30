<?php

class aprsGeoConvert {
	// This class assumes default format: 'decimal'
	static function LonToAprs($decimal) {
		$p = explode('.', $decimal);
		return sprintf(''/*INSERT MAGIC HERE*/);
	}

	// Everything below here is unsupported
  static function ddd2dmm($ddd) {
    return self::DDD2LL($ddd, "DMM");
  }

  static function ddd2dms($ddd) {
    return self::DDD2LL($ddd, "DMS");
  }

  static function dmm2ddd($dmm) {
    $LL = explode(" ", $dmm);
    return self::DMM2LL($LL[0], $LL[1], "DDD");
  }

  static function dmm2dms($dmm) {
    $LL = explode(" ", $dmm);
    return self::DMM2LL($LL[0], $LL[1], "DMS");
  }

  static function dms2ddd($dmm) {
    $LL = explode(" ", $dmm);
    return self::DMS2LL($LL[0], $LL[1], $LL[2], "DDD");
  }

  static function dms2dmm($dmm) {
    $LL = explode(" ", $dmm);
    return self::DMS2LL($LL[0], $LL[1], $LL[2], "DMM");
  }



	##### Convert DDD into DMM and DMS
	private function DDD2LL($LL, $to) {

			// To DMM
			if($to == "DMM") {
				$Split = explode(".", $LL);
				$tmpD = $Split[0];
				$tmpMM = $LL - ( $tmpD * 1.0 );
				$tmpMM = ( $tmpMM * 60.0 );
				$ref = $tmpD." ".$tmpMM;
			}

			// To DMS
			if($to == "DMS") {
				$Split = explode(".", $LL);
				$tmpD = $Split[0];
				$tmpMM = $LL - ( $tmpD * 1.0 );
				$tmpMM = ( $tmpMM * 60.0 );

				$SplitMM = explode(".", $tmpMM);
				$tmpM = $SplitMM[0];
				$tmpSS = $tmpMM - ( $tmpM * 1.0 );
				$tmpSS = ( $tmpSS * 60.0 );
				$ref = $tmpD." ".$tmpM." ".$tmpSS;
			}
  return $ref;
  }

	##### Convert DMM into DDD and DMS
  private function DMM2LL($LLd, $LLm, $to) {

		# Calculate

			// To DDD
			if($to == "DDD") {
				$ref = ( ( $LLd * 1.0 ) + ( $LLm / 60.0 ) );
			}

			// To DMS
			if($to == "DMS") {
				$SplitMM = explode(".", $LLm);
				$tmpM = $SplitMM[0];
				$tmpSS = $LLm - ( $tmpM * 1.0 );
				$tmpSS = ( $tmpSS * 60.0 );
				$ref = $LLd." ".$tmpM." ".$tmpSS;
			}
		return $ref;
  }

	##### Convert DMS into DDD and DMM
  private function DMS2LL($LLd, $LLm, $LLs, $to) {

		# Calculate

			// To DDD
			if($to == "DDD") {
				$tmp = ( $LLm  + ( $LLs / 60.0 ) );
				$ref = ( $LLd  + ( $tmp / 60.0 ) );
			}

			// To DMM
			if($to == "DMM") {
				$ref = $LLd." ".( $LLm + ( $LLs / 60.0 ) );
			}
		return $ref;
		}
}