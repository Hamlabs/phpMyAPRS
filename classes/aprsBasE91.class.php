<?php

/*
This class reads/writes the aprs compressed string.
*/

class aprsBasE91 {


  var $geopos;
  var $symbol;
  var $range;
  var $altitude;
  var $course;
  var $speed;

  var $data = array(
          "geopos"    => array(
                          "lat"  => 00.00,
                          "long" => 00.00
          ),
          "symbol"    => "\\!",
          "range"     => 0,
          "altitude"  => 0,
          "course"    => 0,
          "speed"     => 0,
          "tByte"     => array(
                          "origin" => 010,
                          "source" => 00,
                          "fix"    => 0,
          )
        );



	static function encode($dataArray) {

    // data array structure as self::$data
    
    // Minimum required data is symbol and position ## The quality control needs to be a lot better in production
    if(empty($dataArray['geopos']['lat']) || empty($dataArray['geopos']['long']) || empty($dataArray['symbol']) ) {
      echo "Missing required data\r\n";
      exit;
    }

    // compress lat/long (in +/-ddd format)
    $y['raw'] = ( 380926 * (90-$dataArray['geopos']['lat']));
    $y['p3']  = sprintf('%.9f',( $y['raw']/pow(91,3) ));
    $y['p2']  = sprintf('%.9f',( (($y['p3'] - floor($y['p3']))*pow(91,3))/pow(91,2) ));
    $y['p1']  = sprintf('%.9f',( (($y['p2'] - floor($y['p2']))*pow(91,2))/pow(91,1) ));
    $y['p0']  = sprintf('%.9f',( (($y['p1'] - floor($y['p1']))*pow(91,1)) ));

    $y['p3']  = chr( $y['p3'] +33 );
    $y['p2']  = chr( $y['p2'] +33 );
    $y['p1']  = chr( $y['p1'] +33 );
    $y['p0']  = chr( $y['p0'] +33 );


    $x['raw'] = ( 190463 * (180+$dataArray['geopos']['long']));
    $x['p3']  = sprintf('%.9f',( $x['raw']/pow(91,3) ));
    $x['p2']  = sprintf('%.9f',( (($x['p3'] - floor($x['p3']))*pow(91,3))/pow(91,2) ));
    $x['p1']  = sprintf('%.9f',( (($x['p2'] - floor($x['p2']))*pow(91,2))/pow(91,1) ));
    $x['p0']  = sprintf('%.9f',( (($x['p1'] - floor($x['p1']))*pow(91,1)) ));

    $x['p3']  = chr( intval($x['p3']) +33 );
    $x['p2']  = chr( intval($x['p2']) +33 );
    $x['p1']  = chr( intval($x['p1']) +33 );
    $x['p0']  = chr( intval($x['p0']) +33 );


    // Assemble T byte
    if(!isset($dataArray['tByte']['origin'])) $dataArray['tByte']['origin'] = "010";
    if(!isset($dataArray['tByte']['source'])) $dataArray['tByte']['source'] = "00";
    if(!isset($dataArray['tByte']['fix']))    $dataArray['tByte']['fix']    = "0";
    
    $tByte = chr( bindec("00".$dataArray['tByte']['fix'].$dataArray['tByte']['source'].$dataArray['tByte']['origin']) +33);


    // Find contents of CS
    if($dataArray['tByte']['source'] == "10") { // CS Must be altitude in feet
      
      $a = round(log($dataArray['altitude']) / log(1.002));
      $b = $a/91;
      $c  = sprintf('%.9f',( (($b - floor($b))*pow(91,1)) ));
      
      $cByte = chr($b+33);
      $sByte = chr($c+33);

    } else 
    if($dataArray['range'] > 0) { // Range is set.. superseeds course/Speed 
      
      $a = $dataArray['range']/2;
      $b = round(log($a) / log(1.08));

      $cByte = chr(123); // {
      $sByte = chr($b+33);

    } else
    if($dataArray['course'] > 0 || $dataArray['speed'] > 0 ) { // Range is set.. superseeds course/Speed 

      $c = $dataArray['course'] / 4;
      $cByte = chr($c+33);

      $s1 = $dataArray['speed'] +1;
      $s2 = round(log($s1) / log(1.08));
      $sByte = chr($s2+33);
 
    } else {
      // No additional data, make C == SPACE
      $cByte = chr(32);
      $sByte = chr(33);
    }


    //Building required datastring
    $SymPos = $dataArray['symbol'][0].$y['p3'].$y['p2'].$y['p1'].$y['p0'].$x['p3'].$x['p2'].$x['p1'].$x['p0'].$dataArray['symbol'][1].$cByte.$sByte.$tByte;

  return $SymPos;
	}



	static function decode($dataString) {
	
        /*
        This function need $dataString to be set to a valid 13 char string
        Depending on the contents of $dataString, decode will set some of the following vars
        */
        
        // $dataString is always 13-characters long
        if(strlen($dataString) != 13) break;

        // Slice'n Dice (ref. aprs 101, page 37)
        $symbol = $dataString[0].$dataString[9];
        $y1 = ord($dataString[1]) - 33;
        $y2 = ord($dataString[2]) - 33;
        $y3 = ord($dataString[3]) - 33;
        $y4 = ord($dataString[4]) - 33;
        $x1 = ord($dataString[5]) - 33;
        $x2 = ord($dataString[6]) - 33;
        $x3 = ord($dataString[7]) - 33;
        $x4 = ord($dataString[8]) - 33;
        $c  = ord($dataString[10])- 33;
        $s  = ord($dataString[11])- 33;
        $T  = ord($dataString[12])- 33;
        
        // Lat/Long Decoding
        $latitude  = aprsGeoConvert::ddd2dmm(  (90 - ($y1*pow(91,3) + $y2*pow(91,2) + $y3*pow(91,1) + $y4) / 380926) );
        $longitude = aprsGeoConvert::ddd2dmm(-180 + ($x1*pow(91,3) + $x2*pow(91,2) + $x3*pow(91,1) + $x4) / 190463 );
        $result['geopos'] = array($latitude,$longitude);
        
        // The Compression Type (T) Byte
        $tBinary = "00".decbin($T); // dec2bin tar ikke med leading zero
        if(strlen($tBinary) <> 8 ) {
          echo "Byte does not contain 8 bit! (".strlen($tBinary).") ->".$tBinary."\r\n";
                exit;
        } else {
          $result['tByte']['origin'] = substr($tBinary,5,3);
          $result['tByte']['source'] = substr($tBinary,3,2);
          $result['tByte']['fix']    = substr($tBinary,2,1);
        }
        
        // T byte format (for future use)
        // T byte segments   | notInUse1 | notInUse2 | fix | source | origin |
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
        
        if($result['tByte']['source'] == "10") { // GGA sentence, cs == altitude
          $result['altitude'] = pow(1.002, ((91*$c)+$s));  // feet
        } else
        
        if($c == 90) { // If c == {, s == Pre-Calculated Radio Range
          $result['range'] = 2* pow(1.08, $s); // miles
        } else
        
        if($c <= 89 || $c >= 0) {
          $result['course'] = 4 * $c ;     // degrees
          $result['speed']  = pow(1.08, $s) -1;  // Knots
        } else {
        
        // All failed, something is wrong!
        echo "Explanation";
             exit;
        }

  // Return decoded data
  return $result;
  }



}