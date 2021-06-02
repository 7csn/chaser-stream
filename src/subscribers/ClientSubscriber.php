<?php

namespace chaser\stream\subscribers;

use chaser\container\ContainerInterface;
use chaser\stream\events\Ready;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\CommunicationSubscribable;

/**
 * 流客户端事件订阅类
 *
 * @package chaser\stream\subscribers
 */
class ClientSubscriber extends Subscriber
{
    use CommunicationSubscribable;

    /**
     * @inheritDoc
     */
    public static function events(): array
    {
        return [Ready::class => 'ready'] + CommunicationSubscribable::events();
    }

    /**
     * 构造方法
     *
     * @param ContainerInterface $container
     * @param ClientInterface $client
     */
    public function __construct(protected ContainerInterface $container, protected ClientInterface $client)
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
