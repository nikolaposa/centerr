# CentErr

[![Build Status][ico-build]][link-build]
[![Code Quality][ico-code-quality]][link-code-quality]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Latest Version][ico-version]][link-packagist]
[![PDS Skeleton][ico-pds]][link-pds]

CentErr has been inspired by the Central Error Handler concept that wraps the entire system to handle any uncaught application exception in a standardized and uniform way.

Once caught, exceptions or errors should be displayed to the user in a way that is appropriate for the mode in which application is used. For this purpose, CentErr offers different **Emitter** strategies for delivering error information in a format suitable for a *port* (web, CLI, API) application has been invoked through.

Before being shown to the user, errors typically require some pre-processing with a specific purpose. Therefore, CentErr features **Processors** that can be hooked into the error handling procedure, with concrete implementations for logging and suppressing errors.

## Installation

The preferred method of installation is via [Composer](http://getcomposer.org/). Run the following command to install the latest version of a package and add it to your project's `composer.json`:

```bash
composer require nikolaposa/centerr
```

## Usage

TBD

## Credits

- [Nikola Poša][link-author]
- [All Contributors][link-contributors]

## License

Released under MIT License - see the [License File](LICENSE) for details.


[ico-version]: https://img.shields.io/packagist/v/nikolaposa/centerr.svg
[ico-build]: https://travis-ci.org/nikolaposa/centerr.svg?branch=master
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/nikolaposa/centerr.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/nikolaposa/centerr.svg
[ico-pds]: https://img.shields.io/badge/pds-skeleton-blue.svg

[link-packagist]: https://packagist.org/packages/nikolaposa/centerr
[link-build]: https://travis-ci.org/nikolaposa/centerr
[link-code-coverage]: https://scrutinizer-ci.com/g/nikolaposa/centerr/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/nikolaposa/centerr
[link-pds]: https://github.com/php-pds/skeleton
[link-author]: https://github.com/nikolaposa
[link-contributors]: ../../contributors
