<?php

namespace NotificationChannels\Dayu;

use DomainException;
use Illuminate\Notifications\Notification;
use NotificationChannels\Dayu\Exceptions\CouldNotSendNotification;

class DayuChannel
{
    /**
     * The Top client instance.
     *
     * @var \TopClient
     */
    protected $topClient;

    /**
     * The sign name notifications should be sent from.
     *
     * @var string
     */
    protected $from;


    /**
     * @param  \TopClient  $topClient
     */
    public function __construct(\TopClient $topClient)
    {
        $this->topClient = $topClient;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return mixed
     *
     * @throws \NotificationChannels\Dayu\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $to = $notifiable->routeNotificationFor('dayu')) {
            throw CouldNotSendNotification::missingTo();
        }

        $message = $notification->toDayu($notifiable);

        if (is_string($message)) {
            $message = new DayuMessage($message);
        }

        if (! $from = $message->from ?: config('services.dayu.sms_from')) {
            throw CouldNotSendNotification::missingFrom();
        }
        if (! $template = $message->template ?: config('services.dayu.sms_template')) {
            throw CouldNotSendNotification::missingTemplateCode();
        }
        if (! $type = $message->type ?: config('services.dayu.sms_type')) {
            throw CouldNotSendNotification::missingSmsType();
        }
        try {
            $smsRequest = new \AlibabaAliqinFcSmsNumSendRequest();

            $smsRequest->setSmsType($type);
            $smsRequest->setSmsFreeSignName($from);
            if($extend = $message->extend)
                $smsRequest->setExtend($extend);
            $smsRequest->setSmsTemplateCode($template);
            $smsRequest->setRecNum($to);
            $smsRequest->setSmsParam(trim($message->content));

            $response = $this->topClient->execute($smsRequest);

            return $response;
        } catch (DomainException $exception) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($exception);
        }
    }
}
