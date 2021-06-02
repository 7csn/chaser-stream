<?php

namespace chaser\stream\subscribers;

use chaser\container\ContainerInterface;
use chaser\stream\events\{Start, Stop};
use chaser\stream\interfaces\ServerInterface;

/**
 * 流服务器事件订阅类
 *
 * @package chaser\stream\subscribers
 */
class ServerSubscriber extends Subscriber
{
    /**
     * @inheritDoc
     */
    public static function events(): array
    {
        return [Start::class => 'start', Stop::class => 'stop'] + parent::events();
    }

    /**
     * 构造方法
     *
     * @param ContainerInterface $container
     * @param ServerInterface $server
     */
    public function __construct(protected ContainerInterface $container, protected ServerInterface $server)
    {
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
