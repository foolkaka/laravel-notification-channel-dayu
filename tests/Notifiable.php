<?php

namespace NotificationChannels\Dayusms\Test;

class Notifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForDayusms()
    {
        return '18611100000';
    }
}
