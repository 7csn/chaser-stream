<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\event\Dispatcher;

/**
 * 事件
 *
 * @package chaser\stream\traits
 */
trait Event
{
    /**
     * 事件调度器
     *
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * 事件缓存库
     *
     * @var object[]
     */
    protected array $events = [];

    /**
     * 初始化事件调度器
     */
    protected function initEventDispatcher()
    {
        $this->dispatcher = new Dispatcher();
    }

    /**
     * 判断给定订阅者类型是否可用
     *
     * @param string $class
     * @return bool
     */
    final public static function subscribable(string $class): bool
    {
        $subscriber = static::subscriber();
        return $class instanceof $subscriber;
    }

    /**
     * @inheritDoc
     */
    protected function addSubscriber(string $class): bool
    {
        $able = static::subscribable($class);
        if ($able) {
            $this->dispatcher->addSubscriber(new $class($this));
        }
        return $able;
    }

    /**
     * 事件分发
     *
     * @param string $class
     * @param mixed ...$args
     */
    protected function dispatch(string $class, ...$args)
    {
        $this->dispatcher->dispatch(new $class(...$args));
    }

    /**
     * 缓存事件分发
     *
     * @param string $class
     */
    protected function dispatchCache(string $class)
    {
        $event = $this->events[$class] ??= new $class;
        $this->dispatcher->dispatch($event);
    }

    /**
     * 重置事件调度器
     */
    protected function dispatchClear()
    {
        $this->dispatcher->clear();
        $this->events = [];
    }
}
