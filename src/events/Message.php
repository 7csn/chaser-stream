<?php

declare(strict_types=1);

namespace chaser\stream\events;

use chaser\stream\traits\PropertyReadable;

/**
 * 消息事件
 *
 * @package chaser\stream\events
 */
class Message
{
    use PropertyReadable;

    /**
     * 消息
     *
     * @var string|object
     */
    protected $message;

    /**
     * 初始化消息
     *
     * @param string|object $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }
}
