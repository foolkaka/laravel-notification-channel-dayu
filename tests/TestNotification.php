<?php

namespace NotificationChannels\Dayusms\Test;

use Illuminate\Notifications\Notification;
use NotificationChannels\Dayusms\DayusmsMessage;

class TestNotification extends Notification
{
    public function toDayusms($notifiable)
    {
        return (new DayusmsMessage)
                ->content('{"level":"P0", "service":"aos-common", "info":"502"}')
                ->from('MiFit');
    }
}
