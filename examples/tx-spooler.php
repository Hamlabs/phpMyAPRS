<?php

require_once('classes/aprsBootstrap.class.php');
aprsBootstrap::boot('config.ini');

// Set up APRS-IS connection
$aprs = new aprsIsConnection();

$aprs->executeTransmitSpooler();


