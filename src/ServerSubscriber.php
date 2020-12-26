<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\event\SubscriberInterface;
use chaser\stream\events\Start;
use chaser\stream\events\Stop;

/**
 * 服务器事件订阅者
 *
 * @package chaser\stream
 */
class ServerSubscriber implements SubscriberInterface
{
    /**
     * 服务器
     *
     * @var Server
     */
    protected Server $server;

    /**
     * 初始化服务器
     *
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @inheritDoc
     */
    public function events(): array
    {
        return [
            Start::class => 'start',
            Stop::class => 'stop'
        ];
    }

    /**
     * 启动事件响应
     *
     * @param Start $event
     */
    public function start(Start $event): void
    {
    }

    /**
     * 停止事件响应
     *
     * @param Stop $event
     */
    public function stop(Stop $event): void
    {
    }
}
