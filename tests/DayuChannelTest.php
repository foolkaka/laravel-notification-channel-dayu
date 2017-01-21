<?php

namespace NotificationChannels\Dayu\Test;

use Mockery;
use Illuminate\Notifications\Notification;
use Orchestra\Testbench\TestCase;
use NotificationChannels\Dayu\DayuChannel;
use NotificationChannels\Dayu\DayuMessage;
use NotificationChannels\Dayu\Exceptions\CouldNotSendNotification;

class DayuChannelTest extends TestCase
{
    /** @var \Mockery\Mock */
    protected $topClient;

    /** @var \NotificationChannels\Dayu\DayuChannel */
    protected $channel;

    /** @var Notification */
    protected $notification;

    /** @var DayuMessage */
    protected $message;

    public function setUp()
    {
        parent::setUp();
        $this->topClient = Mockery::mock(\TopClient::class);
        $this->channel = new DayuChannel($this->topClient);
        $this->notification = Mockery::mock(Notification::class);
        $this->message = Mockery::mock(DayuMessage::class);
    }

    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    /** @test */
    public function it_can_send_a_notification()
    {
        $notifiable = new Notifiable;

        //$this->message->from = "Prosper"; need to refactor this!
        $this->notification->shouldReceive('toDayu')
            ->with($notifiable)
            ->andReturn($this->message);


        $this->topClient->shouldReceive('execute')
            ->with(Mockery::mock(\AlibabaAliqinFcSmsNumSendRequest::class));

        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send($notifiable, $this->notification);
    }

    /** @test */
    public function it_does_not_send_a_message_when_notifiable_does_not_have_route_notificaton_for_dayu()
    {
        $this->notification->shouldReceive('toDayu')->never();
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send(new NotifiableWithoutRouteNotificationForDayu, $this->notification);
    }

    /** @test */
    public function it_throws_an_exception_when_it_could_not_send_the_notification()
    {
        $notifiable = new Notifiable;

        $this->notification->shouldReceive('toDayu')
            ->with($notifiable)
            ->andReturn($this->message);

        $this->topClient->shouldReceive('execute')
            ->with(Mockery::mock(\AlibabaAliqinFcSmsNumSendRequest::class));
        $this->setExpectedException(CouldNotSendNotification::class);
        $this->channel->send($notifiable, $this->notification);
    }
}

class NotifiableWithoutRouteNotificationForDayu extends Notifiable
{
    public function routeNotificationFor($channel)
    {
        return false;
    }
}
