<?php

declare(strict_types=1);

namespace chaser\stream\events;

use chaser\stream\traits\PropertyReadable;
use Stringable;

/**
 * 通信消息事件类
 *
 * @package chaser\stream\events
 *
 * @property-read Stringable $message
 */
class Message
{
    use PropertyReadable;

    /**
     * 初始化消息
     *
     * @param Stringable $message
     */
    public function __construct(private Stringable $message)
    {
    }
}
