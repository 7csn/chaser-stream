<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\events\{Close, Connect, Message};

/**
 * 通信事件订阅者相关
 *
 * @package chaser\stream\traits
 */
trait CommunicationSubscribable
{
    use Subscribable;

    /**
     * 订阅事件库
     *
     * @var string[]
     */
    protected array $events = [
        Close::class => 'close',
        Connect::class => 'connect',
        Message::class => 'message'
    ];

    /**
     * 关闭事件响应
     *
     * @param Close $event
     */
    public function close(Close $event): void
    {
    }

    /**
     * 连接事件响应
     *
     * @param Connect $event
     */
    public function connect(Connect $event): void
    {
    }

    /**
     * 消息事件响应
     *
     * @param Message $event
     */
    public function message(Message $event): void
    {
    }
}
