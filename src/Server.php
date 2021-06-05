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
     * 是否处于接收中
     *
     * @var bool
     */
    private bool $accepting = false;

    /**
     * 是否处于停止中
     *
     * @var bool
     */
    private bool $stopping = true;

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
        if ($this->socket) {
            $this->listen();
            $this->running();
        }
    }

    /**
     * @inheritDoc
     */
    public function stop(): void
    {
        if ($this->stopping === false) {
            $this->stopping = true;
            $this->dispatch(Stop::class);
            $this->unListen();
            $this->reactor->destroy();
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
        if ($this->socket === null) {
            $this->internalSubscription();
            $this->createSocket();
            $this->configureSocket();
            $this->createSocketHandle();
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
     * 创建套接字资源
     *
     * @throws ServerCreatedException
     */
    protected function createSocket(): void
    {
        $socketAddress = self::getSocketAddress();
        $errno = 0;
        $errStr = '';
        $context = $this->getContext();
        $this->socket = stream_socket_server($socketAddress, $errno, $errStr, static::$flags, $context) ?: null;
        if ($this->socket === null) {
            throw new ServerCreatedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $errno, $errStr));
        }
    }

    /**
     * 配置套接字
     */
    protected function configureSocket(): void
    {
        // 非阻塞模式
        stream_set_blocking($this->socket, false);
    }

    /**
     * 新建套接字资源处理
     */
    protected function createSocketHandle(): void
    {
        $this->setReadReact([$this, 'accept']);
    }

    /**
     * 服务器运行
     */
    protected function running(): void
    {
        $this->dispatch(Start::class);
        $this->reactor->loop();
    }

    /**
     * 关闭服务器资源
     */
    protected function close(): void
    {
        $this->closeSocket();
        $this->dispatcher->clear();
    }
}
