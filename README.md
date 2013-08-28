# IP User Location

A basic PHP wrapper for adding IP based user location detection into your application.

## Methods

### City based information (getCity())
Returns city level information about an IP address.

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

### Country based information (getCountry())
Returns country level information about an IP address. Obviously this is faster than retrieving city level information.

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

### Validate an IP address (validIP())
Checks to see if the specified IP Address is valid.

### Get the user's IP address (getIpAddress())
Returns the users IP address.

**You shouldn't be trusting a user based this data, HTTP headers can be faked trivially**

## API keys & query limits
You can get a (free) API key [here](http://ipinfodb.com/register.php), obviously this should be kept private.

There are no strict query limits, however if you send more than 2 requests per second they will be queued. You will still get a response, but it will be slowed to around 1 /second.

I would strongly suggest using some form of cache.

## Todo
- Allow devs not to pass an IP address (since it isn't require by the API)
- ~~[Allow devs to choose format (raw, xml, json)](https://github.com/BeingTomGreen/IP-User-Location/commit/b98be870b9ab725eaa49b09934eb6da26a8a3c18)~~
- Add getIP() method?
- ~~[Allow devs to choose API version](https://github.com/BeingTomGreen/IP-User-Location/commit/1a698e07d7ba6c7a3f190e0bad91f22e83694fc1)~~

## License

This is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).