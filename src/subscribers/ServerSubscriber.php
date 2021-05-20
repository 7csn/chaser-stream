<?php

namespace chaser\stream\subscribers;

use chaser\container\ContainerInterface;
use chaser\stream\events\{SocketClose, ServerStart, ServerStop};
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
        return [
            ServerStart::class => 'start',
            ServerStop::class => 'stop',
            SocketClose::class => 'close'
        ];
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
     * @param ServerStart $event
     */
    public function start(ServerStart $event): void
    {
    }

    /**
     * 停止事件响应
     *
     * @param ServerStop $event
     */
    public function stop(ServerStop $event): void
    {
    }

    /**
     * 关闭流资源事件响应
     *
     * @param SocketClose $event
     */
    public function close(SocketClose $event): void
    {
    }
}
