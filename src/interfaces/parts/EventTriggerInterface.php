<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 事件触发器
 *
 * @package chaser\stream\interfaces\parts
 */
interface EventTriggerInterface
{
    /**
     * 事件绑定
     *
     * @param string $event
     * @param callable $callback
     */
    public function on(string $event, callable $callback);

    /**
     * 事件解除
     *
     * @param string $event
     */
    public function off(string $event);

    /**
     * 事件触发
     *
     * @param int $event
     * @param mixed ...$args
     */
    public function trigger(int $event, ...$args);
}
