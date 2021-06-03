<?php

declare(strict_types=1);

namespace chaser\stream\event;

use chaser\stream\traits\PropertyReadable;
use Stringable;

/**
 * 通信消息事件类
 *
 * @package chaser\stream\event
 *
 * @property-read Stringable|string $message
 */
class Message
{
    use PropertyReadable;

    /**
     * 初始化消息
     *
     * @param Stringable|string $message
     */
    public function __construct(private Stringable|string $message)
    {
    }
}
