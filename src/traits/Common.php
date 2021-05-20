<?php

namespace chaser\stream\traits;

use chaser\container\ContainerInterface;
use chaser\container\exception\NotFoundException;
use chaser\container\exception\ResolvedException;
use chaser\event\Dispatcher;
use chaser\reactor\Driver;
use chaser\stream\events\SocketClose;
use chaser\stream\interfaces\parts\CommonInterface;
use Throwable;

/**
 * 公共特性（容器、属性配置、事件驱动、事件调度、套接字流）
 *
 * @package chaser\stream\traits
 *
 * @property array $configurations
 *
 * @see CommonInterface
 */
trait Common
{
    /**
     * IoC 容器
     *
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * 事件反应驱动
     *
     * @var Driver
     */
    protected Driver $reactor;

    /**
     * 事件调度器
     *
     * @var Dispatcher
     */
    protected Dispatcher $dispatcher;

    /**
     * 主套接字流
     *
     * @var resource|null
     */
    protected $socket;

    /**
     * @inheritDoc
     */
    public function configure(array $options): void
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
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        return $this->{$name} ?? $this->configurations[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function invalid(): bool
    {
        return !is_resource($this->socket) || feof($this->socket);
    }

    /**
     * @inheritDoc
     */
    public function addSubscriber(string $class): bool
    {
        try {
            $object = $this->container->make($class, [$this->container, $this]);
        } catch (NotFoundException | ResolvedException) {
            return false;
        }

        $subscriber = static::subscriber();
        $able = $object instanceof $subscriber;
        if ($able) {
            $this->dispatcher->addSubscriber($object);
        }
        return $able;
    }

    /**
     * 初始化事件调度器
     */
    protected function initEventDispatcher(): void
    {
        $this->dispatcher = new Dispatcher();
    }

    /**
     * 事件分发
     *
     * @param string $class
     * @param mixed ...$args
     */
    protected function dispatch(string $class, mixed ...$args): void
    {
        try {
            $object = empty($args)
                ? $this->container->get($class)
                : $this->container->make($class, $args);
            $this->dispatcher->dispatch($object);
        } catch (Throwable) {
        }
    }

    /**
     * 清空分发事件及监听
     */
    protected function dispatchClear(): void
    {
        $this->dispatcher->clear();
    }

    /**
     * 关闭套接字资源
     */
    protected function closeSocket(): void
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
            $this->socket = null;
            $this->dispatch(SocketClose::class);
        }
    }

    /**
     * 添加读事件侦听到事件循环
     *
     * @param callable $callback
     * @return bool
     */
    protected function addReadReactor(callable $callback): bool
    {
        return $this->reactor->addRead($this->socket, $callback);
    }

    /**
     * 从事件循环中移除读事件侦听
     *
     * @return bool
     */
    protected function delReadReactor(): bool
    {
        return $this->reactor->delRead($this->socket);
    }
}
