# :rocket: Laravel Slack API :rocket:
Lightweight Laravel 5 wrapper for Slack Web API, including facade and config.

Please note that this implementation is very lightweight meaning you'll need to do some more work than usual, but in return you get a lot more flexibility. This package doesn't provide methods such as `Chat::postMessage(string message)`, it literally provides one method — `SlackApi::execute(string method, array parameters)`.

**:thumbsup: Reasons to use this package to work with Slack API:**
* Automatic compliance of Slack API [rate limits](https://api.slack.com/docs/rate-limits)
* Lightweight, flexible
* Modern Laravel integration
* Test coverage 
* A lot of emoji in this documentation (even with cat! :cat2:) 

## :earth_americas: Installation
**1)** Require Composer package
```bash
composer requiire lisennk/laravel-slack-web-api
```
**2)** Publish config 
```bash
php artisan vendor:publish
```
**3)** Open `config/slack.php` and insert your Slack token to make API requests
```php
'token' => 'your-token-here'
```
**4)** Open `config/app.php`, scroll down to `providers[]` array and add our `\Lisennk\Laravel\SlackWebApi\Providers\SlackApiServiceProvider::class`.

*For example:*
```php
  // ...
  
  'providers' => [
    // ...
    // A whole bunch of providers
    // ...
    
    \Lisennk\Laravel\SlackWebApi\Providers\SlackApiServiceProvider::class
  ],
  
  // ...
```
**5)** If you want to use a Facade, add `\Lisennk\Laravel\SlackWebApi\Facades\SlackApi::class` like provider, but to `aliases[]` array.

*For example:*
```php
  // ...
  
  'aliases' => [
    // ...
    // A whole bunch of aliases
    // ...
    
    'SlackApi' => \Lisennk\Laravel\SlackWebApi\Facades\SlackApi::class
  ],
  
  // ...
```
## :fork_and_knife: Usage

To call Slack API, you need to call `execute` method of `SlackApi` class and pass him Slack Web API method name and some parameters, for example:
```php
$api->execute('method.name', [
  'parameter_one' => 'some-data',
  'parameter_two' => 'some-another-data'
  
  // ...
  
];
```
This will return plain PHP array with data from Slack.

####**1)** Basic example of usage in Controller:
```php
use \Lisennk\Laravel\SlackWebApi\SlackApi;
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

// ...

public function postMessage(SlackApi $api)
{
  try {
    $response = $api->execute('users.info', [
      'user' => 'U1234567890'
    ]);
    
    $name = $response['user']['name'];
    // Do something amazing with data from Slack...
  } catch (SlackApiException $e) {
    return 'Error:' . $e->getMessage();
  }
}

// ...
```
####**2)** Basic usage with Facade:
```php
use \Lisennk\Laravel\SlackWebApi\Exceptions\SlackApiException;

// ...

public function postMessage(SlackApi $api)
{
  try {
    $response = SlackApi::execute('users.info', [
      'user' => 'U1234567890'
    ]);
    
    $name = $response['user']['name'];
    // Do something amazing with data from Slack...
  } catch (SlackApiException $e) {
    return 'Error:' . $e->getMessage();
  }
}

// ...
```
## :hibiscus: Contributing

Feel free to create pull requests, issues and report typos.

