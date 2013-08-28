<?php

// Enable full error reporting
error_reporting(-1);

// Include the class
require_once 'ipinfo.inc.php';

// Get the API key, you could set this anywhere..
require_once 'key.key.php';

// Create a new instance
$ipInfo = new ipInfo (APIKEY);

$userIP = $ipInfo->getIpAddress();

//var_dump($ipInfo->getCity($userIP));
var_dump($ipInfo->getCountry($userIP));