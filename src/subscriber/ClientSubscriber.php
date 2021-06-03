<?php

declare(strict_types=1);

namespace chaser\stream\subscriber;

use chaser\stream\event\Ready;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\CommunicationSubscribable;

/**
 * 流客户端事件订阅类
 *
 * @package chaser\stream\subscriber
 */
class ClientSubscriber extends Subscriber
{
    use CommunicationSubscribable;

    /**
     * @inheritDoc
     */
    public static function events(): array
    {
        return [Ready::class => 'ready'] + CommunicationSubscribable::events() + parent::events();
    }

    /**
     * 构造方法
     *
     * @param ClientInterface $client
     */
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * 准备通信事件响应
     *
     * @param Ready $event
     */
    public function ready(Ready $event): void
    {
    }
}
