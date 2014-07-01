IP User Location
=======

A basic PHP wrapper for adding IP based user location detection into your application using the [IP Info DB API](http://ipinfodb.com/ip_location_api.php).

### Methods

#### Get city based information
You can use `->getCity($ip)` to retrieve city level information about an IP address.

Example json response:

```
{
  "statusCode" : "OK",
  "statusMessage" : "",
  "ipAddress" : "81.149.15.65",
  "countryCode" : "GB",
  "countryName" : "UNITED KINGDOM",
  "regionName" : "ENGLAND",
  "cityName" : "SALISBURY",
  "zipCode" : "SP1 1TP",
  "latitude" : "51.0693",
  "longitude" : "-1.79569",
  "timeZone" : "+01:00"
}
```

#### Get country based information
You can use `->getCountry($ip)` to retrieve country level information about an IP address. Obviously this is faster than retrieving city level information.

Example json response:

```
{
  "statusCode" : "OK",
  "statusMessage" : "",
  "ipAddress" : "81.149.15.65",
  "countryCode" : "GB",
  "countryName" : "UNITED KINGDOM"
}
```

#### Validate an IP address
You can use `->validIP($ip)` to see if the specified IP Address is valid.

Under the hood this uses `filter_var($ip, FILTER_VALIDATE_IP)`, I assume this is pretty solid. If you have any suggestions for a better way of doing this send a pull request or [drop me an email](mailto:tom@beingtomgreen.com).

#### Get the user's IP address
You can use `->getIpAddress()` to retrieve the users IP address.

**You shouldn't be trusting a user based this data, HTTP headers can be faked, trivially.**

### API keys & query limits
You can get a (free) API key [here](http://ipinfodb.com/register.php), obviously this should be kept private.

While there are no strict query limits if you send more than 2 requests per second they will be queued. You will still always get a response, but it will be slowed to around 1 /second.

I would strongly suggest using some form of cache. Cookies (mmm cookies) are probably the easiest way to deal with this:

```php
// Create a new instance
$ipInfo = new ipInfo (APIKEY, 'json');

// Grab the user location info
$location = json_decode($ipInfo->getCountry($userIP));

// Create a cookie holding the country code for 1 hour (3600 seconds)
setcookie('location', $location['countryCode'], time() + 3600);
```

### Todo
- Allow devs not to pass an IP address (since it isn't required by the API)
- The `->getIpAddress()` function [probably needs additional testing](http://stackoverflow.com/questions/1634782/what-is-the-most-accurate-way-to-retrieve-a-users-correct-ip-address-in-php)
- Composer package this badboy

### License

This is open-sourced software licensed under the [MIT license](http://beingtomgreen.mit-license.org/).
