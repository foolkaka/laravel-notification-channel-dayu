<?php

namespace NotificationChannels\Dayusms\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    public static function configurationNotSet()
    {
        return new static(
            'In order to send notification via Dayu you need to add credentials in the `dayu` key of `config.services`.');
    }
}
