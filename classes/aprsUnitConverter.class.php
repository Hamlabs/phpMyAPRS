<?php

class aprsUnitConverter {

	# Define constants
	
	// Distance
	const METER2FOOT 	= 3.2808;
	const METER2INCH 	= 39.3700787401575;
	const FOOT2METER 	= 0.3048;
	const FOOT2INCH 	= 12;
	const INCH2METER 	= 0.0254;
	const INCH2FOOT		= 0.0833333333;

	// Speed
	const KNOTS2KPH		= 1.85200;
	const KNOTS2MS 		= 0.514444444;
	const KNOTS2MPH		= 1.15077945;
	const KPH2KNOTS		= 0.539956803;
	const KPH2MPH		= 0.621371192;
	const KPH2MS		= 0.277777778;
	const MS2KNOTS 		= 1.94384449;
	const MS2KPH 		= 3.6;
	const MS2MPH 		= 2.23693629;
	const MPH2KNOTS		= 0.868976242;
	const MPH2KPH 		= 1.609344;
	const MPH2MS 		= 0.44704;


	// Distance
	static function meterToFoot($unit) {
		$result = ($unit * self::METER2FOOT);
	return $result;
	}
	static function meterToInch($unit) {
		$result = ($unit * self::METER2INCH);
	return $result;
	}
	static function inchToMeter($unit) {
		$result = ($unit * self::INCH2METER);
	return $result;
	}
	static function inchToFoot($unit) {
		$result = ($unit * self::INCH2FOOT);
	return $result;
	}
	static function footToInch($unit) {
		$result = ($unit * self::FOOT2INCH);
	return $result;
	}
	static function footToMeter($unit) {
		$result = ($unit * self::FOOT2METER);
	return $result;
	}


	// Speed
	static function knotsToKPH($unit) {
		$result = ($unit * self::KNOTS2KPH);
	return $result;
	}
	static function knotsToMPH($unit) {
		$result = ($unit * self::KNOTS2MPH);
	return $result;
	}
	static function knotsToMS($unit) {
		$result = ($unit * self::KNOTS2MS);
	return $result;
	}

	static function KPHToKnots($unit) {
		$result = ($unit * self::KPH2KNOTS);
	return $result;
	}
	static function KPHToMPH($unit) {
		$result = ($unit * self::KPH2MPH);
	return $result;
	}
	static function KPHToMS($unit) {
		$result = ($unit * self::KPH2MS);
	return $result;
	}

	static function MSToKPH($unit) {
		$result = ($unit * self::MS2KPH);
	return $result;
	}
	static function MSToKnots($unit) {
		$result = ($unit * self::MS2KNOTS);
	return $result;
	}
	static function MSToMPH($unit) {
		$result = ($unit * self::MS2MPH);
	return $result;
	}

	static function MPHToKPH($unit) {
		$result = ($unit * self::MPH2KPH);
	return $result;
	}
	static function MPHToMS($unit) {
		$result = ($unit * self::MPH2MS);
	return $result;
	}
	static function MPHToKnots($unit) {
		$result = ($unit * self::MPH2KNOTS);
	return $result;
	}

	// Temperatur
	static function celsiusToFahrenheit($unit) {
		$result = ($unit * 1.8) +32;
	return $result;
	}
	static function fahrenheitToCelsius($unit) {
		$result = ($unit-32) * (5/9);
	return $result;
	}
	static function celsiusToKelvin($unit) {
		$result = ($unit + 273.15);
	return $result;
	}
	static function kelvinToCelsius($unit) {
		$result = ($unit - 273.15);
	return $result;
	}
	static function fahrenheitToKelvin($unit) {
		$result = self::celsiusToKelvin(self::fahrenheitToCelsius($unit));
	return $result;
	}
	static function kelvinToFahrenheit($unit) {
		$result = self::celsiusToFahrenheit(self::kelvinToCelsius($unit));
	return $result;
	}

} // EOC