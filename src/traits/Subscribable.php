<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 事件订阅者相关
 *
 * @package chaser\stream\traits
 */
trait Subscribable
{
    /**
     * @inheritDoc
     */
    public function events(): array
    {
        return $this->events;
    }

    /**
     * 设置订阅事件
     *
     * @param string $event
     * @param string $method
     */
    public function setEvent(string $event, string $method)
    {
        $this->events[$event] = $method;
    }

    /**
     * 批量设置订阅事件
     *
     * @param array $events
     */
    public function setEvents(array $events)
    {
        foreach ($events as $event => $method) {
            $this->events[$event] = $method;
        }
    }
}
