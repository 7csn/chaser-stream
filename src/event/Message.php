<?php

declare(strict_types=1);

namespace chaser\stream\event;

use chaser\stream\traits\PropertyReadable;

/**
 * 通信消息事件类
 *
 * @package chaser\stream\event
 *
 * @property-read mixed $message
 */
class Message
{
    use PropertyReadable;

    /**
     * 初始化消息
     *
     * @param mixed $message
     */
    public function __construct(private mixed $message)
    {
    }
}
