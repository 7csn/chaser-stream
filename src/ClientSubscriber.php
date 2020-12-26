<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\event\SubscriberInterface;
use chaser\stream\events\Close;
use chaser\stream\events\Connect;
use chaser\stream\events\Message;
use chaser\stream\traits\Subscribable;

/**
 * 客户端事件订阅者
 *
 * @package chaser\stream
 */
class ClientSubscriber implements SubscriberInterface
{
    use Subscribable;

    /**
     * 订阅事件库
     *
     * @var string[]
     */
    protected array $events = [
        Connect::class => 'connect',
        Message::class => 'message',
        Close::class => 'close'
    ];

    /**
     * 客户端
     *
     * @var Client
     */
    protected Client $client;

    /**
     * 初始化客户端
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
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

    /**
     * 关闭事件响应
     *
     * @param Close $event
     */
    public function close(Close $event): void
    {
    }
}