<?php

/**
	*
	* @author Tom Green <tom@beingtomgreen.com>
	* @link https://bitbucket.org/BeingTomGreen/ip-detection
	* @license UNLICENSE
	*
	* A basic PHP wrapper for the integrating the IP based location into your application.
	* Uses IP Info DB <http://ipinfodb.com/>
	*
	*/
class ipInfo {
	// Holds the API Key
	private $apiKey = null;

	// Hold the version of the API we are working with
	// Fixed to v3 for now
	private $apiVersion = 'v3';

	// Hold the API URL
	private $apiURL = 'http://api.ipinfodb.com/';

	/**
		* __construct
		*
		* @param string $apiKey - Your API Key
		*
		*/
	function __construct($apiKey)
	{
		// Save the API Key
		$this->apiKey = $apiKey;
	}

	/**
		* getCountry
		*
		* Returns the Country level location data
		*
		* @param string $ip - the users IP address
		*
		* @return array/false - data if we have it, otherwise false
		*
		*/
	public function getCountry($ip)
	{
		return $this->execute($ip, 'ip-country');
	}

	/**
		* getCity
		*
		* Returns the City level location data
		*
		* @param string $ip - the users IP address
		*
		* @return array/false - data if we have it, otherwise false
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
		* @param string $ip - The users IP Address
		* @param string $endpoint - The API endpoint we wish to query
		*
		* @return array/bool - data if we have it, otherwise false
		*
		*/
	private function execute($ip, $endpoint)
	{
		// Invalid IP - make a note of it and return false
		if ($this->validIP($ip) == false)
		{
			error_log('Invalid IP Address '. $ip);
			return false;
		}

		// Build the URL
		$url = $this->apiURL . $this->apiVersion .'/'. $endpoint .'/?key='. $this->apiKey .'&ip='. $ip .'&format=json';

		// Initialise CURL
		$handle = curl_init();

		// Set the CURL options we need
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);

		// Grab the data
		$data = curl_exec($handle);

		// Grab the CURL error code and message
		$errorCode = curl_errno($handle);
		$errorMessage = curl_error($handle);

		// Close the CURL connection
		curl_close($handle);

		// Check our error code is 0 (0 means OK!)
		if ($errorCode == 0)
		{
			// Decode the json response
			$data = json_decode($data, true);

			// Check we don't have an error code
			if ($data['statusCode'] != 'OK' or $data['statusMessage'] != '')
			{
				// API error - make a note of it and return false
				error_log('API error: '. $data['statusCode'] .' - '. $data['statusMessage'] .' ('. $this->apiKey .').');
				return false;
			}
			// No errors - cache and return the data
			else
			{
				// Return the data
				return $data;
			}
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
}