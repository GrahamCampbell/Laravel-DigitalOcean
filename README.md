Laravel DigitalOcean
====================

Laravel DigitalOcean was created by, and is maintained by [Graham Campbell](https://github.com/GrahamCampbell), and is a [DigitalOcean PHP API Client](https://github.com/DigitalOceanPHP/Client) bridge for [Laravel](http://laravel.com). It utilises my [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package. Feel free to check out the [change log](CHANGELOG.md), [releases](https://github.com/GrahamCampbell/Laravel-DigitalOcean/releases), [security policy](https://github.com/GrahamCampbell/Laravel-DigitalOcean/security/policy), [license](LICENSE), [code of conduct](.github/CODE_OF_CONDUCT.md), and [contribution guidelines](.github/CONTRIBUTING.md).

![Banner](https://user-images.githubusercontent.com/2829600/71477345-60993680-27e1-11ea-9161-d2c91c65f77a.png)

<p align="center">
<a href="https://xscode.com/grahamcampbell/Laravel-DigitalOcean"><img src="https://xscode.com/assets/promo-banner.svg" alt="Promo Banner"></img></a>
</p>

<p align="center">
<a href="https://github.com/GrahamCampbell/Laravel-DigitalOcean/actions?query=workflow%3ATests"><img src="https://img.shields.io/github/workflow/status/GrahamCampbell/Laravel-DigitalOcean/Tests?label=Tests&style=flat-square" alt="Build Status"></img></a>
<a href="https://github.styleci.io/repos/22224545"><img src="https://github.styleci.io/repos/22224545/shield" alt="StyleCI Status"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen?style=flat-square" alt="Software License"></img></a>
<a href="https://packagist.org/packages/graham-campbell/digitalocean"><img src="https://img.shields.io/packagist/dt/graham-campbell/digitalocean?style=flat-square" alt="Packagist Downloads"></img></a>
<a href="https://github.com/GrahamCampbell/Laravel-DigitalOcean/releases"><img src="https://img.shields.io/github/release/GrahamCampbell/Laravel-DigitalOcean?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

Laravel DigitalOcean requires [PHP](https://php.net) 7.2-7.4. This particular version supports Laravel 6-8.

| DigitalOcean | L5.1               | L5.2               | L5.3               | L5.4               | L5.5               | L5.6               | L5.7               | L5.8               | L6                 | L7                 | L8                 |
|--------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|--------------------|
| 2.2          | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                |
| 3.2          | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                |
| 4.0          | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                |
| 5.4          | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :white_check_mark: | :x:                |
| 6.0          | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :x:                |
| 7.1          | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :x:                | :white_check_mark: | :white_check_mark: | :white_check_mark: |

To get the latest version, simply require the project using [Composer](https://getcomposer.org). 
You will need to install at least one of the following dependencies: `guzzlehttp/guzzle:^6.3.1`, `guzzlehttp/guzzle:^7.0`, or `kriswallsmith/buzz:^0.16`.

For example, to use Guzzle 7:

```bash
$ composer require graham-campbell/digitalocean:^7.1 guzzlehttp/guzzle:^7.0
```

Once installed, if you are not using automatic package discovery, then you need to register the `GrahamCampbell\DigitalOcean\DigitalOceanServiceProvider` service provider in your `config/app.php`.

You can also optionally alias our facade:

```php
        'DigitalOcean' => GrahamCampbell\DigitalOcean\Facades\DigitalOcean::class,
```


## Configuration

Laravel DigitalOcean requires connection configuration.

To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish
```

This will create a `config/digitalocean.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

There are two config options:

##### Default Connection Name

This option (`'default'`) is where you may specify which of the connections below you wish to use as your default connection for all work. Of course, you may use many connections at once using the manager class. The default value for this setting is `'main'`.

##### DigitalOcean Connections

This option (`'connections'`) is where each of the connections are setup for your application. Example configuration has been included, but you may add as many connections as you would like. Note that the 2 supported authentication methods are: `"none"` and `"token"`.


## Usage

##### DigitalOceanManager

This is the class of most interest. It is bound to the ioc container as `'digitalocean'` and can be accessed using the `Facades\DigitalOcean` facade. This class implements the `ManagerInterface` by extending `AbstractManager`. The interface and abstract class are both part of my [Laravel Manager](https://github.com/GrahamCampbell/Laravel-Manager) package, so you may want to go and checkout the docs for how to use the manager class over at [that repo](https://github.com/GrahamCampbell/Laravel-Manager#usage). Note that the connection class returned will always be an instance of `\DigitalOceanV2\Client`.

##### Facades\DigitalOcean

This facade will dynamically pass static method calls to the `'digitalocean'` object in the ioc container which by default is the `DigitalOceanManager` class.

##### DigitalOceanServiceProvider

This class contains no public methods of interest. This class should be added to the providers array in `config/app.php`. This class will setup ioc bindings.

##### Real Examples

Here you can see an example of just how simple this package is to use. Out of the box, the default adapter is `main`. After you enter your authentication details in the config file, it will just work:

```php
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;
// you can alias this in config/app.php if you like

DigitalOcean::droplet()->powerOn(12345);
// we're done here - how easy was that, it just works!

DigitalOcean::size()->getAll();
// this example is simple, and there are far more methods available
```

The digitalocean manager will behave like it is a `\DigitalOceanV2\Client` class. If you want to call specific connections, you can do with the `connection` method:

```php
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;

// select the your_connection_name connection, then get going
DigitalOcean::connection('your_connection_name')->droplet()->getById(12345);
```

With that in mind, note that:

```php
use GrahamCampbell\DigitalOcean\Facades\DigitalOcean;

// writing this:
DigitalOcean::connection('main')->region()->getAll();

// is identical to writing this:
DigitalOcean::region()->getAll();

// and is also identical to writing this:
DigitalOcean::connection()->region()->getAll();

// this is because the main connection is configured to be the default
DigitalOcean::getDefaultConnection(); // this will return main

// we can change the default connection
DigitalOcean::setDefaultConnection('alternative'); // the default is now alternative
```

If you prefer to use dependency injection over facades like me, then you can easily inject the manager like so:

```php
use GrahamCampbell\DigitalOcean\DigitalOceanManager;
use Illuminate\Support\Facades\App; // you probably have this aliased already

class Foo
{
    protected $digitalocean;

    public function __construct(DigitalOceanManager $digitalocean)
    {
        $this->digitalocean = $digitalocean;
    }

    public function bar()
    {
        $this->digitalocean->region()->getAll();
    }
}

App::make('Foo')->bar();
```

For more information on how to use the `\DigitalOceanV2\Client` class we are calling behind the scenes here, check out the docs at https://github.com/DigitalOceanPHP/Client, and the manager class at https://github.com/GrahamCampbell/Laravel-Manager#usage.

##### Further Information

There are other classes in this package that are not documented here. This is because they are not intended for public use and are used internally by this package.


## Security

If you discover a security vulnerability within this package, please send an email to Graham Campbell at graham@alt-three.com. All security vulnerabilities will be promptly addressed. You may view our full security policy [here](https://github.com/GrahamCampbell/Laravel-DigitalOcean/security/policy).


## License

Laravel DigitalOcean is licensed under [The MIT License (MIT)](LICENSE).


## For Enterprise

Available as part of the Tidelift Subscription

The maintainers of `graham-campbell/digitalocean` and thousands of other packages are working with Tidelift to deliver commercial support and maintenance for the open source dependencies you use to build your applications. Save time, reduce risk, and improve code health, while paying the maintainers of the exact dependencies you use. [Learn more.](https://tidelift.com/subscription/pkg/packagist-graham-campbell-digitalocean?utm_source=packagist-graham-campbell-digitalocean&utm_medium=referral&utm_campaign=enterprise&utm_term=repo)
