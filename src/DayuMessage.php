<?php

namespace NotificationChannels\Dayu;

class DayuMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The sign name the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * The sms type
     *
     * @var string
     */
    public $type = 'normal';

    /**
     * The sms extend, will be response.
     *
     * @var string
     */
    public $extend;

    /**
     * @param  string|array $content
     *
     * @return static
     */
    public static function create($content = null)
    {
        return new static($content);
    }

    /**
     * @param  string|array  $content
     */
    public function __construct($content = null)
    {
        if(is_array($content))
            $content = json_encode($content);

        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string|array  $content
     *
     * @return $this
     */
    public function content($content)
    {
        if(is_array($content))
            $content = json_encode($content);
        $this->content = $content;

        return $this;
    }

    /**
     * Set the sign name the message should be sent from.
     *
     * @param  string  $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Set the sms type.
     *
     * @param string $smsType
     *
     * @return $this
     */
    public function type($smsType)
    {
        $this->type = $smsType;

        return $this;
    }

    /**
     * Set the sms extend, not necessary.
     *
     * @param string $extend
     *
     * @return $this
     */
    public function extend($extend)
    {
        $this->extend = $extend;

        return $this;
    }
}
