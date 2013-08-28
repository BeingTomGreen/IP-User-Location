<?php

// Enable full error reporting
error_reporting(-1);

// Include the class
require_once 'ipinfo.inc.php';

// Get the API key, you could set this anywhere..
require_once 'key.key.php';

// Create a new instance
$ipInfo = new ipInfo (APIKEY);

//var_dump($ipInfo->getCity('81.149.15.65'));
var_dump($ipInfo->getCountry('81.149.15.65'));