<?php

namespace chaser\stream;

use chaser\container\ContainerInterface;
use chaser\reactor\Driver;
use chaser\stream\events\ServerStart;
use chaser\stream\exceptions\ServerCreatedException;
use chaser\stream\exceptions\ServerPauseAcceptException;
use chaser\stream\exceptions\ServerResumeAcceptException;
use chaser\stream\interfaces\ServerInterface;
use chaser\stream\subscribers\ServerSubscriber;
use chaser\stream\traits\Common;
use chaser\stream\traits\Context;
use chaser\stream\traits\Service;

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
     * 资源流上下文配置
     *
     * @var array[]
     */
    protected array $contextOptions = [
        'socket' => [
            'backlog' => self::BACKLOG
        ]
    ];

    /**
     * 监听地址
     *
     * @var string
     */
    private string $target;

    /**
     * 接收状态
     *
     * @var bool
     */
    private bool $accepting = false;

    /**
     * 是否处于停止中
     *
     * @var bool
     */
    private bool $stopping = false;

    /**
     * @inheritDoc
     */
    public static function subscriber(): string
    {
        return ServerSubscriber::class;
    }

    /**
     * 构造函数
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

        $this->initEventDispatcher();
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
        $this->listen();
        $this->dispatch(ServerStart::class);
        $this->reactor->loop();
    }

    /**
     * @inheritDoc
     */
    public function stop(): void
    {
        if ($this->stopping === false) {
            $this->unListen();
            $this->stopping = true;
        }
    }

    /**
     * 析构函数：移除网络监听
     *
     * @throws ServerPauseAcceptException
     */
    public function __destruct()
    {
        $this->unListen();
        $this->dispatchClear();
    }

    /**
     * 关闭服务器资源
     */
    protected function close(): void
    {
        if ($this->socket) {
            $this->closeSocket();
        }
    }

    /**
     * 监听网络
     *
     * @throws ServerCreatedException
     * @throws ServerResumeAcceptException
     */
    private function listen(): void
    {
        $this->create();
        $this->resumeAccept();
    }

    /**
     * 移除网络监听
     *
     * @throws ServerPauseAcceptException
     */
    private function unListen(): void
    {
        $this->pauseAccept();
        $this->close();
    }

    /**
     * 创建服务器套接字流
     *
     * @throws ServerCreatedException
     */
    private function create(): void
    {
        if ($this->socket === null) {
            $socketAddress = self::getSocketAddress();
            $context = stream_context_create($this->contextOptions);

            $this->socket = stream_socket_server($socketAddress, $errno, $errStr, static::$flags, $context) ?: null;

            if ($this->socket === null) {
                throw new ServerCreatedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $errno, $errStr));
            }

            stream_set_blocking($this->socket, false);
        }
    }

    /**
     * 开始或继续接收
     *
     * @throws ServerResumeAcceptException
     */
    private function resumeAccept(): void
    {
        if ($this->socket && $this->accepting === false) {
            $this->addReadReactor([$this, 'acceptData'])
                ? $this->accepting = true
                : throw new ServerResumeAcceptException(sprintf('Server[%s] resume accept failed.', $this->getSocketAddress()));
        }
    }

    /**
     * 暂停接收
     *
     * @throws ServerPauseAcceptException
     */
    private function pauseAccept(): void
    {
        if ($this->socket && $this->accepting === true) {
            $this->delReadReactor()
                ? $this->accepting = false
                : throw new ServerPauseAcceptException(sprintf('Server[%s] pause accept failed.', $this->getSocketAddress()));
        }
    }
}
