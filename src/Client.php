<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\reactor\Reactor;
use chaser\stream\exceptions\CreatedException;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\Common;
use chaser\stream\traits\Communication;
use chaser\stream\traits\Service;

/**
 * 流客户端
 *
 * @package chaser\stream
 */
abstract class Client implements ClientInterface
{
    use Communication, Common, Service;

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
     * 初始化
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
     * @return resource
     * @throws CreatedException
     */
    protected function create()
    {
        if (!$this->stream) {

            $listening = $this->socketAddress();

            if (empty($this->contextOptions)) {
                $this->stream = stream_socket_client($listening, $errno, $errStr, static::$timeout, static::$flags);
            } else {
                $context = stream_context_create($this->contextOptions);
                $this->stream = stream_socket_client($listening, $errno, $errStr, static::$timeout, static::$flags, $context);
            }

            if (!$this->stream) {
                throw new CreatedException("Client[$listening] create failed：$errno $errStr");
            }
        }

        return $this->stream;
    }
}
