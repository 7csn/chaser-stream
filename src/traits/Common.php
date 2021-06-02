<?php

namespace chaser\stream\traits;

use chaser\container\ContainerInterface;
use chaser\container\exception\{NotFoundException, ResolvedException};
use chaser\event\Dispatcher;
use chaser\reactor\Driver;
use chaser\stream\events\Close;
use chaser\stream\interfaces\parts\CommonInterface;
use Throwable;

/**
 * 公共特性（容器、属性配置、事件驱动、事件调度、套接字流）
 *
 * @package chaser\stream\traits
 *
 * @property string $subscriber
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
     * 常规配置
     *
     * @var array
     */
    protected array $configurations = [];

    /**
     * 主套接字流
     *
     * @var resource|null
     */
    protected $socket = null;

    /**
     * @inheritDoc
     */
    public function addSubscriber(string $class): bool
    {
        if ($class === '') {
            return false;
        }

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
     * @inheritDoc
     */
    public function invalid(): bool
    {
        return !is_resource($this->socket) || feof($this->socket);
    }

    /**
     * @inheritDoc
     */
    public function configurations(): array
    {
        return ['subscriber' => ''];
    }

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
     * 初始化公共部分信息
     */
    protected function initCommon(): void
    {
        $this->dispatcher = new Dispatcher();

        $this->setConfigurations($this->configurations());
    }

    /**
     * 内部添加事件订阅者
     */
    protected function internalSubscription(): void
    {
        if ($this->subscriber !== '') {
            $this->addSubscriber($this->subscriber);
            $this->subscriber = '';
        }
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
     * 关闭套接字资源
     */
    protected function closeSocket(): void
    {
        if (is_resource($this->socket)) {
            fclose($this->socket);
            $this->socket = null;
            $this->dispatch(Close::class);
        }
    }

    /**
     * 添加读事件侦听到事件循环
     *
     * @param callable $callback
     * @return bool
     */
    protected function addReadReact(callable $callback): bool
    {
        return $this->reactor->addRead($this->socket, $callback);
    }

    /**
     * 从事件循环中移除读事件侦听
     *
     * @return bool
     */
    protected function delReadReact(): bool
    {
        return $this->reactor->delRead($this->socket);
    }

    /**
     * 内部批量配置属性
     *
     * @param array $options
     */
    protected function setConfigurations(array $options): void
    {
        $this->configurations = array_merge($this->configurations, $options);
    }
}
