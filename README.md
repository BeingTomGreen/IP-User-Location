# IP Info

A basic PHP wrapper for integrating IP based user location detection into your application.

## Methods

### City based information (getCity())
Returns city level information about an IP address.

Example response:

    statusCode => "OK"
    statusMessage => ""
    ipAddress => "81.149.15.65"
    countryCode => "GB"
    countryName => "UNITED KINGDOM"
    regionName => "ENGLAND"
    cityName => "LONDON"
    zipCode => "-"
    latitude => "51.5085"
    longitude => "-0.12574"
    timeZone => "+01:00"

### Country based information (getCountry())
Returns country level information about an IP address. Obviously this is faster than retrieving city level information.

Example response:

    statusCode => "OK"
    statusMessage => ""
    ipAddress => "81.149.15.65"
    countryCode => "GB"
    countryName => "UNITED KINGDOM"

## API keys & query limits
You can get a (free) API key [here](http://ipinfodb.com/register.php), obviously this should be kept private.

There are no strict query limits, however if you send more than 2 requests per second they will be queued. You will still get a response, but it will be slowed to around 1 /second.

I would strongly suggest using some form of cache.

## License
This is free and unencumbered software released into the public domain. See UNLICENSE for more details.