# flowplayer-php-client
a php client for interacting with flowplayer drive

Composer Installation:
Add/integrate the following to your project's composer.json file. 

```javascript
"repositories": [ 
	{
		"type": "git",
		"url": "git@github.com:mattbucci/flowplayer-php-client.git"
	}
],
"require": {
    "mattbucci/flowplayer-php-client": "dev-master"
}
```

Then run `composer update mattbucci/flowplayer-php-client`

# Configuration

If using Laravel, after it's installed run

```bash
php artisan vendor:publish
```

And then configure the file at /config/flowplayer-php-client.php.
This file can be used to override the default parameters set within src/APICaller when using the laravel service provider configuration.


# Usage
If using within laravel add the following to your providers list

```php
Flowplayer\FlowplayerServiceProvider
```

For non-laravel applications simply directly invoke the API Client.

```php
$client = new \Flowplayer\Client(new \Flowplayer\APICaller(new GuzzleHttp\Client(), [
    'username' => 'janedoe',
    'password' => '1234'
]));
```

## Note: this package is developed completely independently from flowplayer.org I am in no way affliated with them. This software is provided as is and was intended for my own use.
