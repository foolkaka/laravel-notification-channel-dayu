<?php

namespace NotificationChannels\Dayu\Test;

use Illuminate\Notifications\Notification;
use NotificationChannels\Dayu\DayuMessage;

class TestNotification extends Notification
{
    public function toDayu($notifiable)
    {
        return (new DayuMessage)
                ->content('{"level":"P0", "service":"aos-common", "info":"502"}')
                ->from('MiFit');
    }
}
