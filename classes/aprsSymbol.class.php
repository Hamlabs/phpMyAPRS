<?php

class aprsSymbol {

  const POLICE = "/!";
  const RESERVED = "/\"";
  const DIGI = "/#";
  const PHONE = "/$";
  const DX_CLUSTER = "/%";
  const HF_GATEWAY = "/&";
  const SMALL_AIRCRAFT = "/'";
  const MOBILE_SATELLITE_STATION = "/(";
  const WHEELCHAIR = "/)";
  const SNOWMOBILE = "/*";
  const RED_CROSS = "/+";
  const BOY_SCOUTS = "/,";
  const HOUSE_QTH = "/-";
  const X = "/.";
  const RED_DOT = "//";
  const CIRCLE_0 = "/\0";
  const CIRCLE_1 = "/1";
  const CIRCLE_2 = "/2";
  const CIRCLE_3 = "/3";
  const CIRCLE_4 = "/4";
  const CIRCLE_5 = "/5";
  const CIRCLE_6 = "/6";
  const CIRCLE_7 = "/7";
  const CIRCLE_8 = "/8";
  const CIRCLE_9 = "/9";
  const FIRE = "/:";
  const CAMPGROUND = "/;";
  const MOTORCYCLE = "/<";
  const RAILROAD_ENGINE = "/=";
  const CAR = "/>";
  const FILESERVER = "/?";
  const HC_FUTURE_PREDICT = "/@";
  const AID_STATION = "/A";
  const BBS_PBBS = "/B";
  const CANOE = "/C";
  const EYEBALL = "/E";
  const FARM_VEHICLE = "/F";
  const GRID_SQUARE = "/G";
  const HOTEL = "/H";
  const TCPIP = "/I";
  const SCHOOL = "/K";
  const PC_USER = "/L";
  const MACAPRS = "/M";
  const NTS_STATION = "/N";
  const BALLOON = "/O";
  const ALT_POLICE = "/P";
  const TBD = "/Q";
  const RECREATIONAL_VEHICLE = "/R";
  const SHUTTLE = "/S";
  const SSTV = "/T";
  const BUS = "/U";
  const ATV = "/V";
  const NATIONAL_WX_SERVICE_SITE = "/W";
  const HELO = "/X";
  const YACHT = "/Y";
  const WINAPRS = "/Z";
  const PERSON = "/[";
  const TRIANGLE = "/\\";
  const MAIL = "/]";
  const LARGE_AIRCRAFT = "/^";
  const WEATHER_STATION = "/_";
  const DISH_ANTENNA = "/`";
  const AMBULANCE = "/a";
  const BIKE = "/b";
  const INCIDENT_COMMAND_POST = "/c";
  const FIRE_DEPARTMENT = "/d";
  const HORSE = "/e";
  const FIRE_TRUCK = "/f";
  const GLIDER = "/g";
  const HOSPITAL = "/h";
  const IOTA = "/i";
  const JEEP = "/j";
  const TRUCK = "/k";
  const LAPTOP = "/l";
  const MICE_REPEATER = "/m";
  const NODE = "/n";
  const EOC = "/o";
  const ROVER = "/p";
  const GRID_SQ = "/q";
  const REPEATER = "/r";
  const SHIP = "/s";
  const TRUCK_STOP = "/t";
  const BIG_RIG = "/u";
  const VAN = "/v";
  const WATER_STATION = "/w";
  const XAPRS = "/x";
  const YAGI_QTH = "/y";
  const ALT_TBD = "/z";
  const TNC_STREAM_SWITCH_1 = "/|";
  const TNC_STREAM_SWITCH_2 = "/~";
  const EMERGENCY = "\\!";
  const ALT_RESERVED = "\\\"";
  const ALT_DIGI = "\\#";
  const BANK = "\\$";
  const POWERPLANT = "\\%";
  const IGATE = "\\&";
  const CRASH = "\\'";
  const CLOUDY = "\\(";
  const FIRENET = "\\)";
  const SNOW = "\\*";
  const CHURCH = "\\+";
  const GIRL_SCOUTS = "\\,";
  const HOUSE = "\\-";
  const AMBIGUOUS = "\\.";
  const WAYPOINT_DESTINATION = "\\/";
  const CIRCLE = "\\\0";
  const NETWORK_NODE = "\\8";
  const GAS_STATION = "\\9";
  const HAIL = "\\:";
  const PARK = "\\;";
  const ADVISORY = "\\<";
  const APRSTT_TOUCHTONE = "\\=";
  const ALT_CAR = "\\>";
  const INFO_KIOSK = "\\?";
  const HURICANE = "\\@";
  const OVERLAYBOX = "\\A";
  const BLOWING_SNOW = "\\B";
  const COAST_GUARD = "\\C";
  const DRIZZLE = "\\D";
  const SMOKE = "\\E";
  const FREEZING_RAIN = "\\F";
  const SNOW_SHOWER = "\\G";
  const HAZE = "\\H";
  const RAIN_SHOWER = "\\I";
  const LIGHTENING = "\\J";
  const KENWOOD = "\\K";
  const LIGHTHOUSE = "\\L";
  const MARS = "\\M";
  const NAVIGATION_BUOY = "\\N";
  const ROCKET = "\\O";
  const PARKING = "\\P";
  const QUAKE = "\\Q";
  const RESTAURANT = "\\R";
  const SATELLITTE = "\\S";
  const THUNDERSTORM = "\\T";
  const SUNNY = "\\U";
  const VORTAC = "\\V";
  const NWS_SITE = "\\W";
  const PHARMACY = "\\X";
  const RADIOS = "\\Y";
  const W_CLOUD = "\\[";
  const GPS = "\\\\";
  const AIRCRAFT = "\\^";
  const WX_SITE = "\\_";
  const RAIN = "\\`";
  const ARRL_ARES_WINLINK = "\\a";
  const BLOWING = "\\b";
  const CD_TRIANGLE = "\\c";
  const DX_SPOT = "\\d";
  const SLEET = "\\e";
  const FUNNEL_CLOUD = "\\f";
  const GALE_FLAGS = "\\g";
  const HAMSTORE = "\\h";
  const BOX = "\\i";
  const WORKZONE = "\\j";
  const SPECIAL_VEHICLE = "\\k";
  const AREAS = "\\l";
  const VALUE_SIGN = "\\m";
  const OVERLAY_TRIANGLE = "\\n";
  const SMALL_CIRCLE = "\\o";
  const PARTIALY_CLOUDED = "\\p";
  const RESTROOMS = "\\r";
  const ALT_SHIP = "\\s";
  const TORNADO = "\\t";
  const ALT_TRUCK = "\\u";
  const ALT_VAN = "\\v";
  const FLOODING = "\\w";
  const WRECK = "\\x";
  const SKYWARN = "\\y";
  const ALT_SHELTER = "\\z";
  const FOG = "\\{";
  const ALT_TNC_STREAM_SWITCH_1 = "\\|";
  const ALT_TNC_STREAM_SWITCH_2 = "\\~";

    // Define Constants
  static $aprsSymbolTable = array(
      '/' => array(
        '!' => "POLICE",
        '"' => "RESERVED",
        '#' => "DIGI",
        '$' => "PHONE",
        '%' => "DX_CLUSTER",
        '&' => "HF_GATEWAY",
        '\'' => "SMALL_AIRCRAFT",
        '(' => "MOBILE_SATELLITE_STATION",
        ')' => "WHEELCHAIR",
        '*' => "SNOWMOBILE",
        '+' => "RED_CROSS",
        ',' => "BOY_SCOUTS",
        '-' => "HOUSE_QTH",
        '.' => "X",
        '/' => "RED_DOT",
        '0' => "CIRCLE_0",
        '1' => "CIRCLE_1",
        '2' => "CIRCLE_2",
        '3' => "CIRCLE_3",
        '4' => "CIRCLE_4",
        '5' => "CIRCLE_5",
        '6' => "CIRCLE_6",
        '7' => "CIRCLE_7",
        '8' => "CIRCLE_8",
        '9' => "CIRCLE_9",
        ':' => "FIRE",
        ';' => "CAMPGROUND",
        '<' => "MOTORCYCLE",
        '=' => "RAILROAD_ENGINE",
        '>' => "CAR",
        '?' => "FILESERVER",
        '@' => "HC_FUTURE_PREDICT",
        'A' => "AID_STATION",
        'B' => "BBS_PBBS",
        'C' => "CANOE",
        'D' => "",
        'E' => "EYEBALL",
        'F' => "FARM_VEHICLE",
        'G' => "GRID_SQUARE",
        'H' => "HOTEL",
        'I' => "TCPIP",
        'J' => "",
        'K' => "SCHOOL",
        'L' => "PC_USER",
        'M' => "MACAPRS",
        'N' => "NTS_STATION",
        'O' => "BALLOON",
        'P' => "ALT_POLICE",
        'Q' => "TBD",
        'R' => "RECREATIONAL_VEHICLE",
        'S' => "SHUTTLE",
        'T' => "SSTV",
        'U' => "BUS",
        'V' => "ATV",
        'W' => "NATIONAL_WX_SERVICE_SITE",
        'X' => "HELO",
        'Y' => "YACHT",
        'Z' => "WINAPRS",
        '[' => "PERSON",
        '\\' => "TRIANGLE",
        ']' => "MAIL",
        '^' => "LARGE_AIRCRAFT",
        '_' => "WEATHER_STATION",
        '`' => "DISH_ANTENNA",
        'a' => "AMBULANCE",
        'b' => "BIKE",
        'c' => "INCIDENT_COMMAND_POST",
        'd' => "FIRE_DEPARTMENT",
        'e' => "HORSE",
        'f' => "FIRE_TRUCK",
        'g' => "GLIDER",
        'h' => "HOSPITAL",
        'i' => "IOTA",
        'j' => "JEEP",
        'k' => "TRUCK",
        'l' => "LAPTOP",
        'm' => "MICE_REPEATER",
        'n' => "NODE",
        'o' => "EOC",
        'p' => "ROVER",
        'q' => "GRID_SQ",
        'r' => "REPEATER",
        's' => "SHIP",
        't' => "TRUCK_STOP",
        'u' => "BIG_RIG",
        'v' => "VAN",
        'w' => "WATER_STATION",
        'x' => "XAPRS",
        'y' => "YAGI_QTH",
        'z' => "ALT_TBD",
        '{' => "",
        '|' => "TNC_STREAM_SWITCH_1",
        '}' => "",
        '~' => "TNC_STREAM_SWITCH_2"
			),
      '\\' => array(
        '!' => "EMERGENCY",
        '"' => "ALT_RESERVED",
        '#' => "ALT_DIGI",
        '$' => "BANK",
        '%' => "POWERPLANT",
        '&' => "IGATE",
        '\'' => "CRASH",
        '(' => "CLOUDY",
        ')' => "FIRENET",
        '*' => "SNOW",
        '+' => "CHURCH",
        ',' => "GIRL_SCOUTS",
        '-' => "HOUSE",
        '.' => "AMBIGUOUS",
        '/' => "WAYPOINT_DESTINATION",
        '0' => "CIRCLE",
        '1' => "",
        '2' => "",
        '3' => "",
        '4' => "",
        '5' => "",
        '6' => "",
        '7' => "",
        '8' => "NETWORK_NODE",
        '9' => "GAS_STATION",
        ':' => "HAIL",
        ';' => "PARK",
        '<' => "ADVISORY",
        '=' => "APRSTT_TOUCHTONE",
        '>' => "ALT_CAR",
        '?' => "INFO_KIOSK",
        '@' => "HURICANE",
        'A' => "OVERLAYBOX",
        'B' => "BLOWING_SNOW",
        'C' => "COAST_GUARD",
        'D' => "DRIZZLE",
        'E' => "SMOKE",
        'F' => "FREEZING_RAIN",
        'G' => "SNOW_SHOWER",
        'H' => "HAZE",
        'I' => "RAIN_SHOWER",
        'J' => "LIGHTENING",
        'K' => "KENWOOD",
        'L' => "LIGHTHOUSE",
        'M' => "MARS",
        'N' => "NAVIGATION_BUOY",
        'O' => "ROCKET",
        'P' => "PARKING",
        'Q' => "QUAKE",
        'R' => "RESTAURANT",
        'S' => "SATELLITTE",
        'T' => "THUNDERSTORM",
        'U' => "SUNNY",
        'V' => "VORTAC",
        'W' => "NWS_SITE",
        'X' => "PHARMACY",
        'Y' => "RADIOS",
        'Z' => "",
        '[' => "W_CLOUD",
        '\\' => "GPS",
        ']' => "",
        '^' => "AIRCRAFT",
        '_' => "WX_SITE",
        '`' => "RAIN",
        'a' => "ARRL_ARES_WINLINK",
        'b' => "BLOWING",
        'c' => "CD_TRIANGLE",
        'd' => "DX_SPOT",
        'e' => "SLEET",
        'f' => "FUNNEL_CLOUD",
        'g' => "GALE_FLAGS",
        'h' => "HAMSTORE",
        'i' => "BOX",
        'j' => "WORKZONE",
        'k' => "SPECIAL_VEHICLE",
        'l' => "AREAS",
        'm' => "VALUE_SIGN",
        'n' => "OVERLAY_TRIANGLE",
        'o' => "SMALL_CIRCLE",
        'p' => "PARTIALY_CLOUDED",
        'q' => "",
        'r' => "RESTROOMS",
        's' => "ALT_SHIP",
        't' => "TORNADO",
        'u' => "ALT_TRUCK",
        'v' => "ALT_VAN",
        'w' => "FLOODING",
        'x' => "WRECK",
        'y' => "SKYWARN",
        'z' => "ALT_SHELTER",
        '{' => "FOG",
        '|' => "ALT_TNC_STREAM_SWITCH_1",
        '}' => "",
        '~' => "ALT_TNC_STREAM_SWITCH_2"
			)
    );


  function makeMyConstants($aprsSymbolTable) {
    foreach( $aprsSymbolTable as $tableByte => $tableData ) {
      foreach( $tableData  as $iconByte => $iconText ) {
        if(!empty($aprsSymbolTable[$tableByte][$iconByte])) {
          if( $tableByte == '\\' || $tableByte == '"' ) { $tableByte2 = '\\'.$tableByte; } else {$tableByte2 = $tableByte;}
          if( $iconByte  == '\\' || $iconByte  == '"' ) { $iconByte2  = '\\'.$iconByte; } else { $iconByte2  = $iconByte;}
         echo "const ".$aprsSymbolTable[$tableByte][$iconByte].' = "'.$tableByte2.$iconByte2.'";'."\r\n";
        }
      }
    }
  }


	static function getOverlay($symbol, $overlay) {
		
      $bytes = str_split($symbol);
      return $overlay.$bytes[1];
	}
	
	
	
	static function getName($symbol) {

    if( strlen($symbol) == 2 ) {
      $bytes = str_split($symbol);
     
      if( $bytes[0] == "/" ||  $bytes[0] == "\\" ) {
        return self::$aprsSymbolTable[$bytes[0]][$bytes[1]];
      } else {
        // Only secondary table has overlay symbols
        return self::$aprsSymbolTable["\\"][$bytes[1]];
      }
    }
	}
	

	static function getBytes($symbol) {

    /*
    if(!empty($symbol)) {
      $name =  strtoupper($symbol);

      foreach(self::$aprsSymbolTable as $tableByte => $TableData) {
        $iconByte = array_search($name, $tableData);
        if(!empty($iconByte)) {
          return $tableByte.$iconByte;
        }
      }
    }
	*/
  return constant('self::'.$symbol);
  }

}

/*
Ex.
echo aprsSymbol::getOverlay(aprsSymbol::TORNADO, "3"); -> "3t"
echo aprsSymbol::getName("\t"); -> "TORNADO"
echo aprsSymbol::getBytes("TORNADO"); -> "\t"
*/
