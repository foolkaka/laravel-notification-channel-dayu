<?php

namespace NotificationChannels\Dayusms\Exceptions;

use Exception;
use DomainException;

class CouldNotSendNotification extends Exception
{
    public static function serviceRespondedWithAnError(DomainException $exception)
    {
        return new static(
            "Service responded with an error '{$exception->getCode()}: {$exception->getMessage()}'");
    }

    /**
     * @return static
     */
    public static function missingFrom()
    {
        return new static('Notification was not sent. Missing `from` number.');
    }

    /**
     * @return static
     */
    public static function missingTo()
    {
        return new static('Notification was not sent. Missing `to` number.');
    }

    /**
     * @return static
     */
    public static function missingTemplateCode()
    {
        return new static('Notification was not sent. Missing `template` code.');
    }

    /**
     * @return static
     */
    public static function missingSmsType()
    {
        return new static('Notification was not sent. Missing sms `type`.');
    }
}
