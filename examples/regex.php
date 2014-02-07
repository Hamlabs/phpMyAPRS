<?php

$ingress = $_SERVER['argv'][1];

$matches = array();
preg_match('/på grunn av ([\wæøåÆØÅ]+(\s+[\wæøåÆØÅ]+)*)(\.| etter| i periodene\:)/', $ingress, $matches);

var_dump($matches);


