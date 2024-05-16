# Generate ShortUrl and QR code 

## Description

This package will help you to generate a short url and get a base64 code which can be used to strcture a QR for the URL.<br> 
This package used Third party provider called [bitly](https://app.bitly.com/ "bitly") which provied different type of services to generate a URL.<br>
This package under the hood handle the third party Errors. Also, provide throttling issue when pass many request to the server.


## Getting Started

### Installation
```shell script
composer require ma/short-link-url
```
### Prerequisites
Create an account **[bitly](https://app.bitly.com/ "bitly")**. So, can you use the token to pass it to the package to generate a URL.

## Examples
After create an account and get the access token which can be used to send a reques to the server.<br>
```shell script
$accessToken = 'YOUR_ACCESS_TOKEN_HERE';
```
Call BitlyShortener class for generate a short URL or generate a QR.<br>
```shell script
$shortener = new BitlyShortener($accessToken);
```
pass The long URL 
```shell script
 $longUrl = 'https://data.stackexchange.com/stackoverflow/query/58883/test-long-url';
```
Next step You can call to methods:<br>
1- Generate a URL 
```shell script
$shortUrl = $shortener->shortenUrl($longUrl);
```
The result when run th example long URL will be <br>
https://bit.ly/49Bh8Uv<br>
1- Generate a base64 code which can be used in image to show QRcode.
**Note:** Under the hood its check if it has a shortURL if no then its generate a new one and make a base64 code from that. 
```shell script
 $qrCode = $shortener->generateQR($longUrl);
 ```
The result will be something like<br>
```shell script
data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAApAAAAKQCAIAAACn190HAAAYsElEQVR4nOzda4xcdf3H8ZnaQmlpLeWmSEmh1UIqgrReg8TYNhqVCPZBMRGrMUoMJCrGilFDCP+UW2rENBptoIZATRPxkliQlJoIXoh4o5Vi0YZQoqUIUuoqdtl2/wmTTA6z22WH7un+Pjuv16PZnZmzvzkznXfP7Ox8Jw8ODjYAgLJNGu8FAAAvT7ABIIBgA0AAwQaAAIINAAEEGwACCDYABBBsAAgg2AAQQLABIIBgA0AAwQaAAIINAAEEGwACCDYABBBsAAgg2AAQQLABIIBgA0AAwQaAAIINAAEEGwACCDYABBBsAAgg2AAQQLABIIBgA0AAwQaAAIINAAEEGwACCDYABBBsAAgg2AAQQLABIIBgA0AAwQaAAIINAAEEGwACCDYABBBsAAgg2AAQQLABIIBgA0AAwQaAAIINAAEEGwACCDYABBBsAAgg2AAQQLABIIBgA0AAwQaAAI....
```
## License

The model is open-sourced licensed under the [MIT license](https://opensource.org/license/MIT "License MIT").
