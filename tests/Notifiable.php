<?php

namespace NotificationChannels\Dayu\Test;

class Notifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * @return int
     */
    public function routeNotificationForDayu()
    {
        return '18611100000';
    }
}
