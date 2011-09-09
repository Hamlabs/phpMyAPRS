<?php


class dbCon {

        // Define vars
        private $server_type ;
        private $server_addr ;
        private $server_port ;
        private $server_user ;
        private $server_pass ;
        private $server_dbName ; 

        private $server_query ; 

        private $tmpRes1 ; 
        private $tmpRes2 ; 
        public         $result ; 
        public         $resCount ; 
        public         $resCountF ; 

        private $error;

        // Autorun at startup
        function __construct($server_type, $server_addr = "", $server_user = "", $server_pass = "", $server_dbName = "",  $server_port = "") {
        
                // If server data is asigned, apply!
                try {
                
                        if(empty($server_type) ) {

                                throw new Exception("Server type is empty or invalid!");
                                
                        }  else {

                                if($this->setSrvType($server_type) || ( $server_type != "mySQL" && $server_type != "SQLite" )) { 
          unset($server_addr);
        } else {
          throw new Exception("Unable to set dbCon type.");
        }

                                if(!empty($server_addr)) {
                                        if($this->setSrvAddr($server_addr)         === true)     { unset($server_addr);}          else        {        throw new Exception("Unable to set dbCon address.");}
                                }
                                if(!empty($server_user)) {
                                        if($this->setSrvUser($server_user)         === true)     { unset($server_user);}          else        {        throw new Exception("Unable to set dbCon user.");}
                                }
                                if(!empty($server_pass)) {
                                        if($this->setSrvPass($server_pass)         === true)     { unset($server_pass);}          else        {        throw new Exception("Unable to set dbCon password.");}
                                }
                                if(!empty($server_dbName)) {
                                        if($this->setSrvDbname($server_dbName)        === true) { unset($server_dbName);}        else        {        throw new Exception("Unable to set dbCon database.");}
                                }
                                if(!empty($server_port)) {
                                if($this->setSrvPort($server_port)         === true)       { unset($server_port);}          else        {        throw new Exception("Unable to set dbCon port.");}
                                }

                                switch ($server_type) {
                                // Sjekk samtidig at alle parametre for gitte tilkobling er satt .. slik at vi ikke får problemer senere..
                                #        case "SQLite": if($this->setSrvType($server_type) === true ) { unset($server_addr): throw new Exception("Unable to set dbCon port.");

                                        case "mySQL":
                                                if($this->setSrvType($server_type) === true ) { unset($server_addr);}          else        {throw new Exception("Unable to set dbCon type.");}
                                                break;
                                                
                                        default : 
            if($this->setSrvType($server_type) === true ) { unset($server_addr);}          else        {throw new Exception("Unable to set dbCon port.");}
                                }
                        }
                } 
                
                catch (Exception $e) {
                        echo 'Object contstruction failed: ',  $e->getMessage(), "\r\n";
                }
        }


        // Config methods
        private function setVal($name,$value) {
                $this->$name = $value ;        unset($value);
                return true;
        }

        public function setSrvType($value) {
                return $this->setVal('server_type', $value);
        }

        public function setSrvAddr($value) {
                return $this->setVal('server_addr', $value);
        }

        public function setSrvPort($value) {
                return $this->setVal('server_port', $value);
        }

        public function setSrvUser($value) {
                return $this->setVal('server_user', $value);
        }

        public function setSrvPass($value) {
                return $this->setVal('server_pass', $value);
        }

        public function setSrvDB($value) {
                return $this->setVal('server_dbName', $value);
        }
        
        
// Handler for query
        public function query($server_query) {

                try {
                        switch ($this->server_type) {

                                case "SQLite":
                                        // Do something smart.
                                        break;
                                
                                case "mySQL":
                                        $this->mySQLconnect();                                // connect
                                        $this->mySQLquery($server_query);         // qyery
                                        $this->mySQLclose();                                // close
                                        break;

                                default: throw new Exception("Invalid servertype.");
                        }
                }
                
                catch (Exception $e) {
                        echo 'Query failed: ',  $e->getMessage(), "\r\n";
                }

        }



// mySQL methods

        // Preforming mySQL connection
        private function mySQLconnect() {
                try {
                        if(!@mysql_connect($this->server_addr, $this->server_user, $this->server_pass)) {throw new Exception("Connection failed: ".mysql_error());}
                        if(!@mysql_select_db($this->server_dbName)) {throw new Exception("Unable to select database: ".mysql_error());}

                        $this->status = "Tilkobling OK!";
                }

                catch (Exception $e) {
                        $this->error =  $e->getMessage() . "\r\n";
                        $this->status = "Tilkobling FEILET";
                }
        }

        // execute query
        private function mySQLquery($query) {

                // Må forbedre exeptions her
                try {
                        /* anti SQL injection */
                        $query = mysql_real_escape_string($query);

                        $this->tmpRes1 = @mysql_query($query);
                        $this->resCount = @mysql_num_rows($this->tmpRes1);
                        $this->resCountF = @mysql_num_fields($this->tmpRes1);

                        if($this->resCount > 0) {
                                while($this->tmpRes2 = mysql_fetch_assoc($this->tmpRes1)) {
                                        $this->result[] = $this->tmpRes2;
                                }
                        } else {
                                $this->result[0] = null;
                        }
                
                        if(mysql_error()) {throw new Exception("Something is wrong: ".mysql_error());}
                }

                catch (Exception $e) {
                        $this->error =  $e->getMessage() . "\r\n";
                }
        }
        
        // close db connection
        private function mySQLclose() {
                try {
                        if(!@mySQL_close()) {throw new Exception("Unable to close database connection: ".mysql_error());}
                }

                catch (Exception $e) {
                        $this->error =  $e->getMessage() . "\r\n";
                }
        }


// SQLite methods


} // class end