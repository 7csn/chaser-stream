<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\container\ContainerInterface;
use chaser\reactor\Driver;
use chaser\stream\event\{Start, Stop};
use chaser\stream\exception\ServerCreatedException;
use chaser\stream\interfaces\ServerInterface;
use chaser\stream\traits\{Common, Context, Service};

/**
 * 流服务器类
 *
 * @package chaser\stream
 */
abstract class Server implements ServerInterface
{
    use Common, Context, Service;

    /**
     * 监听网络标志组合
     *
     * @var int
     */
    protected static int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;

    /**
     * 监听地址
     *
     * @var string
     */
    protected string $target;

    /**
     * 是否处于运行中
     *
     * @var bool
     */
    private bool $running = false;

    /**
     * 是否处于接收中
     *
     * @var bool
     */
    private bool $accepting = false;

    /**
     * @inheritDoc
     */
    public static function configurations(): array
    {
        return ['context' => []] + Common::configurations();
    }

    /**
     * 构造方法
     *
     * @param ContainerInterface $container
     * @param Driver $reactor
     * @param string $target
     */
    public function __construct(ContainerInterface $container, Driver $reactor, string $target)
    {
        $this->container = $container;
        $this->reactor = $reactor;
        $this->target = $target;

        $this->initCommon();

        $this->contextualize(['socket' => ['backlog' => self::BACKLOG]]);
    }

    /**
     * 获取网络监听地址
     *
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @inheritDoc
     */
    public function start(): void
    {
        if ($this->running === false) {
            $this->running = true;
            $this->listen();
            $this->dispatch(Start::class);
            $this->reactor->loop();
        }
    }

    /**
     * @inheritDoc
     */
    public function stop(): void
    {
        if ($this->running) {
            $this->running = false;
            $this->dispatch(Stop::class);
            $this->unListen();
        }
    }

    /**
     * 析构函数：移除网络监听
     */
    public function __destruct()
    {
        $this->unListen();
    }

    /**
     * 监听网络
     *
     * @throws ServerCreatedException
     */
    protected function listen(): void
    {
        $this->internalSubscription();

        if ($this->socket === null) {
            $socketAddress = self::getSocketAddress();
            $errno = 0;
            $errStr = '';
            $context = $this->getContext();
            $this->socket = stream_socket_server($socketAddress, $errno, $errStr, static::$flags, $context) ?: null;
            if ($this->socket === null) {
                throw new ServerCreatedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $errno, $errStr));
            }
            $this->socketHandle();
            $this->addReadReact([$this, 'accept']);
        }
    }

    /**
     * 移除网络监听
     */
    protected function unListen(): void
    {
        if ($this->socket) {
            $this->delReadReact();
            $this->close();
        }
    }

    /**
     * 关闭服务器资源
     */
    protected function close(): void
    {
        $this->closeSocket();
        $this->dispatcher->clear();
    }

    /**
     * 套接字资源处理
     */
    protected function socketHandle(): void
    {
        stream_set_blocking($this->socket, false);
    }
}
