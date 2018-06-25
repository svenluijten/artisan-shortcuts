![artisan-shortcuts](https://user-images.githubusercontent.com/11269635/41874111-3489070c-78c7-11e8-920a-de918c4a0cc4.jpg)

# Laravel Artisan Shortcuts

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-circleci]][link-circleci]
[![StyleCI][ico-styleci]][link-styleci]

Have you ever executed 2 or 3 artisan commands _over_, and _over_, and _over_ in
your Laravel projects? Me too! That's what prompted this package. With it, you can
define "shortcuts" to bundle up those commonly used commands into short, memorable
names (or long, convoluted ones, that's up to you!).

## Index
- [Installation](#installation)
  - [Downloading](#downloading)
  - [Registering the service provider](#registering-the-service-provider)
  - [Publishing the configuration file](#publishing-the-configuration-file)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)

## Installation
You'll have to follow a couple of simple steps to install this package.

### Downloading
Via [composer](http://getcomposer.org):

```bash
$ composer require sven/artisan-shortcuts
```

Or add the package to your dependencies in `composer.json` and run
`composer update` on the command line to download the package:

```json
{
    "require": {
        "sven/artisan-shortcuts": "^1.0"
    }
}
```


### Registering the service provider
If you're [not using auto-discovery](https://laravel.com/docs/5.6/packages#package-discovery),
register `Sven\ArtisanShortcuts\ServiceProvider::class` in your `config/app.php` file.

### Publishing the configuration file
To publish this package's configuration file, execute the following command and pick
`Sven\ArtisanShortcuts\ServiceProvider` from the list:

```bash
$ php artisan vendor:publish
```

## Usage
Defining your own artisan shortcuts is fairly straight forward. Take a look at the following
configuration:

```php
return [
    'custom-command' => [
        FirstCommand::class => [
            '--option' => 'value',
        ],
        SecondCommand::class,
    ],
];
```

Running `php artisan custom-command` will execute `FirstCommand` with the option `--option=value`,
and `SecondCommand` without any arguments or options.

Something I use this for all the time is [Barry van den Heuvel's `laravel-ide-helper` commands](https://github.com/barryvdh/laravel-ide-helper):

```php
return [
    'ide' => [
        GeneratorCommand::class,
        ModelsCommand::class => ['--nowrite' => true],
        MetaCommand::class,
    ],
];
```

Instead of using the FQCN for the command classes, you can also use the command name:

```php
return [
    'clear' => [
        'cache:clear',
        'config:clear',
        'view:clear',
    ],
];
```

## Contributing
All contributions (pull requests, issues and feature requests) are
welcome. Make sure to read through the [CONTRIBUTING.md](CONTRIBUTING.md) first,
though. See the [contributors page](../../graphs/contributors) for all contributors.

## License
`sven/artisan-shortcuts` is licensed under the MIT License (MIT). Please see the
[license file](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/sven/artisan-shortcuts.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-green.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/sven/artisan-shortcuts.svg?style=flat-square
[ico-circleci]: https://img.shields.io/circleci/project/github/svenluijten/artisan-shortcuts.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/138423783/shield

[link-packagist]: https://packagist.org/packages/sven/artisan-shortcuts
[link-downloads]: https://packagist.org/packages/sven/artisan-shortcuts
[link-circleci]: https://circleci.com/gh/svenluijten/artisan-shortcuts
[link-styleci]: https://styleci.io/repos/138423783
