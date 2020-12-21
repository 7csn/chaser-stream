<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 事件触发器
 *
 * @package chaser\stream\traits
 */
trait EventTrigger
{
    /**
     * @inheritDoc
     */
    public function on(string $event, callable $callback)
    {
        if (isset($this->eventTriggers[$event])) {
            $this->eventTriggers[$event][] = $callback;
        }
    }

    /**
     * @inheritDoc
     */
    public function off(string $event)
    {
        if (isset($this->eventTriggers[$event])) {
            $this->eventTriggers[$event] = [];
        }
    }

    /**
     * @inheritDoc
     */
    public function trigger(int $event, ...$args)
    {
        if (isset($this->eventTriggers[$event])) {
            foreach ($this->eventTriggers[$event] as $callback) {
                $callback(...$args);
            }
        }
    }
}
