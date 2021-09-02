# Livewire DataTables

[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/amiranagram/livewire-datatables/run-tests?label=tests&style=flat-square)](https://github.com/amiranagram/livewire-datatables/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/amirami/livewire-datatables.svg?style=flat-square)](https://packagist.org/packages/amirami/livewire-datatables)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/amirami/livewire-datatables.svg?style=flat-square)](https://packagist.org/packages/amirami/livewire-datatables)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/amiranagram/livewire-datatables/Check%20&%20fix%20styling?label=code%20style&style=flat-square)](https://github.com/amiranagram/livewire-datatables/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)

Livewire DataTables components for back-end. Modular, easy to use, with tons of features.

Inspired by [Caleb's](https://github.com/calebporzio) [Livewire Screencasts](https://laravel-livewire.com/screencasts), dedicated to my friend [Bardh](https://github.com/bardh7).

## Installation

You can install the package via composer:

```bash
composer require amirami/livewire-datatables
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Amirami\LivewireDataTables\LivewireDataTablesServiceProvider" --tag="livewire-datatables-config"
```

This is the contents of the published config file:

```php
return [

    'multi_column_sorting' => false,

    'row_caching' => false,

];
```

## Usage

After creating your Livewire component, extend the component class with `Amirami\LivewireDataTables\DataTable`. The `DataTable` abstract class will ask you to implement `getQueryProperty` method. This is a computed property in Livewire which needs to return and instance of `Illuminate\Database\Eloquent\Builder` or `\Illuminate\Database\Eloquent\Relations\Relation`.

This is the part where you will build the base of your query, with filters.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Amir Rami](https://github.com/amiranagram)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
