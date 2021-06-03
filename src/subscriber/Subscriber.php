<?php

declare(strict_types=1);

namespace chaser\stream\subscriber;

use chaser\event\Listener;
use chaser\stream\event\Close;
use chaser\stream\interfaces\SubscriberInterface;

/**
 * 流服务事件订阅基类
 *
 * @package chaser\stream\subscriber
 */
abstract class Subscriber implements SubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function events(): array
    {
        return [Close::class => 'close'];
    }

    /**
     * @inheritDoc
     */
    public function listeners(): array
    {
        $listeners = [];
        foreach (static::events() as $event => $method) {
            $listeners[] = new Listener($event, [$this, $method]);
        }
        return $listeners;
    }

    /**
     * 关闭套接字资源事件响应
     *
     * @param Close $event
     */
    public function close(Close $event): void
    {
    }
}
