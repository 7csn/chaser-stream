<?php

namespace chaser\stream\subscribers;

use chaser\event\Listener;
use chaser\stream\events\Close;
use chaser\stream\interfaces\SubscriberInterface;

/**
 * 流服务事件订阅基类
 *
 * @package chaser\stream\subscribers
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
     * 关闭事件响应
     *
     * @param Close $event
     */
    public function close(Close $event): void
    {
    }
}
