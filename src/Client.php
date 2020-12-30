<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\reactor\Reactor;
use chaser\stream\events\OpenConnectionFail;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\{Communication, Helper, Service};

/**
 * 流客户端
 *
 * @package chaser\stream
 */
abstract class Client implements ClientInterface
{
    use Communication, Helper, Service;

    /**
     * 事件反应器
     *
     * @var Reactor
     */
    protected Reactor $reactor;

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
     * 常规配置
     *
     * @var array
     */
    protected array $configurations = [];

    /**
     * 构造函数
     *
     * @param Reactor $reactor
     * @param string $address
     */
    public function __construct(Reactor $reactor, string $address)
    {
        $this->reactor = $reactor;
        $this->remoteAddress = $address;

        $this->initEventDispatcher();
    }

    /**
     * @inheritDoc
     */
    public function target(): string
    {
        return $this->remoteAddress;
    }

    /**
     * 创建客户端套接字流
     *
     * @return bool
     */
    protected function create(): bool
    {
        if (!$this->stream) {

            $this->stream = $this->openConnection($this->socketAddress(), $errno, $errStr, static::$timeout, static::$flags);

            if (!$this->stream) {
                $this->dispatch(OpenConnectionFail::class, $errno, $errStr);
                return false;
            }
        }

        return true;
    }

    /**
     * 打开到服务器套接字流的连接
     *
     * @param string $address
     * @param int $errno
     * @param string $errStr
     * @param int $timeout
     * @param int $flags
     * @return false|resource
     */
    protected function openConnection(string $address, int &$errno, string &$errStr, int $timeout, int $flags)
    {
        return stream_socket_client($address, $errno, $errStr, $timeout, $flags);
    }
}
