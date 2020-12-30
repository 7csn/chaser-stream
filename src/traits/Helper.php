<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\event\Dispatcher;
use chaser\stream\events\Close;
use Throwable;

/**
 * 助手（配置、事件调度、套接字流）
 *
 * @package chaser\stream\traits
 */
trait Helper
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
     * 主套接字流
     *
     * @var resource
     */
    protected $stream;

    /**
     * @inheritDoc
     */
    public function addSubscriber(string $class): bool
    {
        $object = new $class($this);
        $subscriber = static::subscriber();
        $able = $object instanceof $subscriber;
        if ($able) {
            $this->dispatcher->addSubscriber($object);
        }
        return $able;
    }

    /**
     * @inheritDoc
     */
    public function set(array $options)
    {
        foreach ($options as $name => $value) {
            if (gettype($this->{$name}) === gettype($value)) {
                $this->configurations[$name] = $value;
            }
        }
    }

    /**
     * 属性、配置项可读
     *
     * @param string $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        return $this->{$name} ?? $this->configurations[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function invalid(): bool
    {
        return !is_resource($this->stream) || feof($this->stream);
    }

    /**
     * 关闭套接字资源
     */
    protected function closeSocket()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
        $this->stream = null;
        $this->dispatchCache(Close::class);
        $this->dispatcher->clear();
        $this->events = [];
    }

    /**
     * 初始化事件调度器
     */
    protected function initEventDispatcher()
    {
        $this->dispatcher = new Dispatcher();
    }

    /**
     * 事件分发
     *
     * @param string $class
     * @param mixed ...$args
     */
    protected function dispatch(string $class, ...$args)
    {
        try {
            $this->dispatcher->dispatch(new $class(...$args));
        } catch (Throwable $e) {
        }
    }

    /**
     * 缓存事件分发
     *
     * @param string $class
     */
    protected function dispatchCache(string $class)
    {
        try {
            $event = $this->events[$class] ??= new $class;
            $this->dispatcher->dispatch($event);
        } catch (Throwable $e) {
        }
    }
}
