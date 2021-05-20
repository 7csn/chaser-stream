<?php

namespace chaser\stream\subscribers;

use chaser\event\Listener;
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
    public function listeners(): array
    {
        $listeners = [];
        foreach (static::events() as $event => $method) {
            $listeners[] = new Listener($event, [$this, $method]);
        }
        return $listeners;
    }
}
