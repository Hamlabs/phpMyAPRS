<?php
require_once('autoload.php');
require_once('aprsis.class.php');

$packet = new aprsObject();
//$packet->setRawContent("GB7YD-S>APJID2,TCPIP*,qAC,GB7YD-GS:;GB7YD  C *5335.17ND00121.43WaRNG0060 2m Voice 145.675 -0.600 MHz");
$packet->setRawContent("GB7YD-S>APJID2,TCPIP*,qAC,GB7YD-GS:;GB7YD  C *080826z5335.17ND00121.43WaRNG0060 2m Voice 145.675 -0.600 MHz");
var_dump($packet);

echo $packet;
