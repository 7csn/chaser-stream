<?php

namespace chaser\stream;

use chaser\container\ContainerInterface;
use chaser\reactor\Driver;
use chaser\stream\exceptions\ClientCreatedException;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\{Common, Communication, Service};

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

        $this->initCommon();
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
     * @throws ClientCreatedException
     */
    public function create(): void
    {
        $this->internalSubscription();

        if ($this->socket === null) {
            $socketAddress = $this->getSocketAddress();
            $errorNumber = 0;
            $errorMessage = '';
            $this->socket = $this->createSocket($socketAddress, $errorNumber, $errorMessage, static::$timeout, static::$flags);
            if ($this->socket === null) {
                throw new ClientCreatedException(sprintf('Server[%s] create failed：%d %s', $socketAddress, $errorNumber, $errorMessage));
            }
        }
    }

    /**
     * 打开到服务器的套接字连接
     *
     * @param string $address
     * @param int $errno
     * @param string $errStr
     * @param int $timeout
     * @param int $flags
     * @return resource|null
     */
    protected function createSocket(string $address, int &$errno, string &$errStr, int $timeout, int $flags)
    {
        $socket = stream_socket_client($address, $errno, $errStr, $timeout, $flags);
        return $socket === false ? null : $socket;
    }
}
