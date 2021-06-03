<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\event\Message;
use chaser\stream\interfaces\SubscriberInterface;

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
        return [Message::class => 'message'];
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
