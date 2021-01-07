<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\event\SubscriberInterface;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\CommunicationSubscribable;
use chaser\stream\events\OpenConnectionFail;

/**
 * 客户端事件订阅者
 *
 * @package chaser\stream
 */
class ClientSubscriber implements SubscriberInterface
{
    use CommunicationSubscribable;

    /**
     * 客户端
     *
     * @var ClientInterface
     */
    protected ClientInterface $client;

    /**
     * 初始化客户端
     *
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
        $this->setEvent(OpenConnectionFail::class, 'openConnectionFail');
    }

    /**
     * 关闭事件响应
     *
     * @param OpenConnectionFail $event
     */
    public function openConnectionFail(OpenConnectionFail $event): void
    {
    }
}
