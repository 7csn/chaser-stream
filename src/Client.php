<?php

namespace chaser\stream;

use chaser\container\ContainerInterface;
use chaser\reactor\Driver;
use chaser\stream\exceptions\ClientConnectedException;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\subscribers\ClientSubscriber;
use chaser\stream\traits\Common;
use chaser\stream\traits\Communication;
use chaser\stream\traits\Service;

/**
 * 流客户端类
 *
 * @package chaser\stream
 */
abstract class Client implements ClientInterface
{
    use Common, Communication, Service;

    /**
     * 监听网络标志组合
     *
     * @var int
     */
    protected static int $flags = STREAM_CLIENT_ASYNC_CONNECT;

    /**
     * 连接超时时间
     *
     * @var int
     */
    protected static int $timeout = 0;

    /**
     * 创建套接字流误号
     *
     * @var int
     */
    protected int $errorNumber = 0;

    /**
     * 创建套接字流信息
     *
     * @var string
     */
    protected string $errorMessage = '';

    /**
     * @inheritDoc
     */
    public function addSubscriber(string $class): bool
    {
        return ClientSubscriber::class;
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
        $this->remoteAddress = $target;

        $this->initEventDispatcher();
    }

    /**
     * 获取网络监听地址
     *
     * @return string
     */
    public function getTarget(): string
    {
        return $this->remoteAddress;
    }

    /**
     * 创建客户端套接字流
     *
     * @throws ClientConnectedException
     */
    public function create(): void
    {
        if ($this->socket === null) {
            $socketAddress = $this->getSocketAddress();
            $this->socket = $this->openConnection($socketAddress, $this->errorNumber, $this->errorMessage, static::$timeout, static::$flags);
            if ($this->socket === null) {
                throw new ClientConnectedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $this->errorNumber, $this->errorMessage));
            }
        }
    }

    /**
     * 打开到服务器套接字流的连接
     *
     * @param string $address
     * @param int $errno
     * @param string $errStr
     * @param int $timeout
     * @param int $flags
     * @return resource|null
     */
    protected function openConnection(string $address, int &$errno, string &$errStr, int $timeout, int $flags)
    {
        return stream_socket_client($address, $errno, $errStr, $timeout, $flags) ?: null;
    }
}
