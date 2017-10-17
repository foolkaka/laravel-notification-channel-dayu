# Alibaba Dayu SMS notifications channel for Laravel 5.4


This package makes it easy to send [Dayu Sms notifications](https://api.alidayu.com/docs/api.htm?spm=a3142.7395905.4.6.KVF6uS&apiId=25450) with Laravel 5.4.

## Contents

- [Installation](#installation)
    - [Setting up your Dayu account](#setting-up-your-dayu-account)
- [Usage](#usage)
    - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require huami-cloud/laravel-notification-channel-dayusms
```

You must install the service provider:

```php
// config/app.php
'providers' => [
    ...
    NotificationChannels\Dayusms\DayusmsServiceProvider::class,
],
```

### Setting up your Dayu account

Add your Dayu Account App Key, App Secret, Sms Template Code (optional), Sign Name as sms_from(optional) to your `config/services.php`:

```php
// config/services.php
...
'dayu' => [
    'app_key' => env('DAYU_APP_KEY'),
    'app_secret' => env('DAYU_APP_SECRET'),
    'format' => 'json',
    'log_dir' => '/tmp',
    'sms_from' => env('DAYU_SMS_SIGN_NAME'),
    'sms_type' => 'normal',
    'sms_template' => env('DAYU_SMS_TEMPLATE','SMS_9655108')
],
...
```

## Usage

Now you can use the channel in your `via()` method inside the notification:

``` php
use NotificationChannels\Dayusms\DayusmsChannel;
use NotificationChannels\Dayusms\DayusmsMessage;
use Illuminate\Notifications\Notification;

class ValentineDateApproved extends Notification
{
    public function via($notifiable)
    {
        return [DayusmsChannel::class];
    }

    public function toDayusms($notifiable)
    {
        return (new DayusmsMessage())
            ->content('{"level":"P0", "service":"'.$notifiable->service.'", "info":"502"}');
    }
}
```

In order to let your Notification know which phone number you are sending to, add the `routeNotificationForDayusms` method to your Notifiable model e.g your User Model

```php
public function routeNotificationForDayusms()
{
    // where `phone` is a field in your users table;
    // can set multiple phones as string which separated by comma `,` .
    return $this->phone;
}
```

### Available Message methods

#### SmsMessage

- `from('')`: Accepts a sign name to use as the notification sender.
- `content('')`: Accepts a json string value for the notification body.
- `content([])`: Accepts a array value for the notification body.
- `type('')`: Accepts a string value for sms type.
- `template('')`: Accepts a string value for sms template.
- `extend('')`: Accepts a string value for sms callback using.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email hfex@huami.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
