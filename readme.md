# Fireable

[![Latest Version on Packagist][ico-version]][link-packagist]
[![StyleCI](https://styleci.io/repos/209407300/shield)](https://styleci.io/repos/209407300)
[![Total Downloads][ico-downloads]][link-downloads]

An elegant way to trigger events based on attributes changes.

## Installation

Install package through Composer

``` bash
$ composer require envant/fireable
```

## Usage

1. Add the `FireableAttributes` trait to your model
2. Define the attributes with specified events via the `protected $fireableAttributes` property on the model

### Example

Let's say we need to trigger specified events when specific model attributes are updated.

For example, you need to notify user when he gets an "approved" status. Instead of observing model's "dirty" attributes and firing events manually we could do it more elegantly by assigning specified events to attributes or even certain values of attributes.

```php
class User extends Authenticatable
{
    use FireableAttributes;

    protected $fireableAttributes = [
        'status' => [
            'approved' => UserApproved::class,
            'rejected' => UserRejected::class,
        ],
    ];
}
```

Also you may not need to track certain values, so you can assign an event directly to an attribute itself. So, in the example below, each time the user's email is changed, the appropriate event will be fired.

```php
class User extends Authenticatable
{
    use FireableAttributes;

    protected $fireableAttributes = [
        'email' => EmailUpdated::class,
    ];
}
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Boris Lepikhin][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/envant/fireable.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/envant/fireable.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/envant/fireable
[link-downloads]: https://packagist.org/packages/envant/fireable
[link-author]: https://github.com/envant
[link-contributors]: ../../contributors
