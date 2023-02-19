# Laravel rules

This package provides some additional validation rules for Laravel.

## Requirements

- PHP 8.1 and above
- Laravel 9 or 10

## Installation

Require this package with composer using the following command:

```bash
composer require bbprojectnet/laravel-rules
```

## Rules

### Base64

Checks whether the given string is a base 64 encoded string.

```php
return [
	'attribute' => [new Base64()],
];
```

### EnumCase

Checks if the given string is one of the enum cases.

```php
return [
	'attribute' => [new EnumCase(Color::class)], // any enum case
	'attribute' => [new EnumCase([Color::Red, Color::Blue])], // selected enum cases
];
```

### Extension

Checks whether the given filename string has one of the allowed extensions.

```php
return [
	'attribute' => [new Extension(['jpg', 'png', 'gif'])],
];
```

### ManyOf

Checks whether the values given in a string (separated, for example, by a comma) meet the specified rule.

```php
$rule = new Extension(['jpg', 'png']);

return [
	'attribute' => [new ManyOf($rule)],
	'attribute' => [(new ManyOf($rule))->delimeter('|')], // with custom delimeter
];
```

## License

The Laravel rules package is open-sourced software licensed under the MIT license.
