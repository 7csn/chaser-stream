<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\interfaces\SubscriberInterface;
use chaser\stream\events\{Close, Message};

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
        return [Close::class => 'close', Message::class => 'message'];
    }

    /**
     * 关闭事件响应
     *
     * @param Close $event
     */
    public function close(Close $event): void
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
