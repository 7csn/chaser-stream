<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\exceptions\CreatedException;
use chaser\stream\interfaces\ClientInterface;
use chaser\stream\traits\Communication;
use chaser\stream\traits\Configuration;
use chaser\stream\traits\Event;
use chaser\stream\traits\Service;
use chaser\stream\traits\Stream;

/**
 * 流客户端
 *
 * @package chaser\stream
 */
abstract class Client implements ClientInterface
{
    use Communication, Configuration, Event, Service, Stream;

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
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->remoteAddress = $address;
    }

    /**
     * @inheritDoc
     */
    public function target(): string
    {
        return $this->remoteAddress;
    }

    /**
     * @inheritDoc
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
