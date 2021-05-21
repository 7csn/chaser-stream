<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\interfaces\SubscriberInterface;
use chaser\stream\events\{SocketClose, Connect, Message};

/**
 * 通信事件订阅特征
 *
 * @package chaser\stream\traits
 *
 * @see SubscriberInterface
 */
trait CommunicationSubscribable
{
    /**
     * @inheritDoc
     */
    public static function events(): array
    {
        return [
            SocketClose::class => 'close',
            Connect::class => 'connect',
            Message::class => 'message'
        ];
    }

    /**
     * 关闭事件响应
     *
     * @param SocketClose $event
     */
    public function close(SocketClose $event): void
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
