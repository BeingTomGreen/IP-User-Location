<?php
/**
  *
  * @author Tom Green <tom@beingtomgreen.com>
  * @link https://github.com/BeingTomGreen/IP-User-Location
  * @license MIT - http://beingtomgreen.mit-license.org/
  *
  * A basic PHP wrapper for the integrating the IP based location into your application.
  * Uses IP Info DB <http://ipinfodb.com/>
  *
  */
class ipInfo {
  // Holds the API Key
  private $apiKey = null;

  // Hold the format we want to return the data in
  private $apiFormat = null;

  // Hold the version of the API we are working with
  private $apiVersion = null;

  // Hold the API URL (should have trailing /)
  private $apiURL = 'http://api.ipinfodb.com/';

  /**
    * __construct
    *
    * @param string $apiKey - Your API key
    * @param string $format - The format we want to return the data in
    * @param string $version - The version of the API we are working with
    *
    */
  function __construct($apiKey, $format = 'raw', $version = 'v3')
  {
    // Save the API key
    $this->apiKey = $apiKey;

    // Save the API format
    $this->apiFormat = $format;

    // Save the API version
    $this->apiVersion = $version;
  }

  /**
    * getCountry
    *
    * Returns country level location data
    *
    * @param string $ip - the users IP address
    *
    * @return string/false - data if we have it, otherwise false
    *
    */
  public function getCountry($ip)
  {
    return $this->execute($ip, 'ip-country');
  }

  /**
    * getCity
    *
    * Returns city level location data
    *
    * @param string $ip - the users IP address
    *
    * @return string/false - data if we have it, otherwise false
    *
    */
  public function getCity($ip)
  {
    return $this->execute($ip, 'ip-city');
  }

  /**
    * execute
    *
    * Makes the specified CURL request - this is the meat of the class!
    *
    * @param string $ip - The users IP address
    * @param string $endpoint - The API endpoint we wish to query
    *
    * @return string/bool - data if we have it, otherwise false
    *
    */
  private function execute($ip, $endpoint)
  {
    // Invalid IP address - make a note of it and return false
    if ($this->validIP($ip) == false)
    {
      error_log('Invalid IP Address '. $ip);
      return false;
    }

    // Build the URL
    $url = $this->apiURL . $this->apiVersion .'/'. $endpoint .'/?key='. $this->apiKey .'&ip='. $ip .'&format='. $this->apiFormat;

    // Initialise CURL
    $handle = curl_init();

    // Set the CURL options we need
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

    // Grab the data
    $data = curl_exec($handle);

    // Grab the CURL error code and message as well as the HTTP Code
    $errorCode = curl_errno($handle);
    $errorMessage = curl_error($handle);
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);

    // Close the CURL connection
    curl_close($handle);

    // Check that we got a good HTTP response code
    if ($httpCode == '200')
    {
      // Check our CURL error code is 0 (0 means OK!)
      if ($errorCode == 0)
      {
        // Return the data
        return $data;
      }
      // Curl Error
      else
      {
        error_log('CURL error: '. $errorMessage .' (URL: '. $url .').');
        return false;
      }
    }
    // Bad HTTP response code
    else
    {
      error_log('Bad HTTP response: '. $httpCode .' (URL: '. $url .').');
      return false;
    }
  }

  /**
    * validIP
    *
    * Checks that the specified string is a valid IP Address
    *
    * @param string $ip - The IP Address
    *
    * @return bool - is the IP Address valid or not?
    *
    */
  public function validIP($ip)
  {
    return filter_var($ip, FILTER_VALIDATE_IP);
  }

  /**
    * getIpAddress
    *
    * Returns the users IP Address
    * This data shouldn't be trusted. Faking HTTP headers is trivial.
    *
    * @return string/false - the users IP address or false
    *
    */
  public function getIPAddress()
  {
    // Try REMOTE_ADDR
    if (isset($_SERVER['REMOTE_ADDR']) and $_SERVER['REMOTE_ADDR'] != '')
    {
      return $_SERVER['REMOTE_ADDR'];
    }
    // Fall back to HTTP_CLIENT_IP
    elseif (isset($_SERVER['HTTP_CLIENT_IP']) and $_SERVER['HTTP_CLIENT_IP'] != '')
    {
      return $_SERVER['HTTP_CLIENT_IP'];
    }
    // Finally fall back to HTTP_X_FORWARDED_FOR
    // I'm aware this can sometimes pass the users LAN IP, but it is a last ditch attempt
    elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and $_SERVER['HTTP_X_FORWARDED_FOR'] != '')
    {
      return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    // Nothing? Return false
    return false;
  }

}