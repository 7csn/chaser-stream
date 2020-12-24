<?php

declare(strict_types=1);

namespace chaser\stream;

use chaser\stream\exceptions\CreatedException;
use chaser\stream\interfaces\ServerInterface;
use chaser\stream\traits\Configuration;
use chaser\stream\traits\Service;
use chaser\stream\traits\Stream;

/**
 * 流服务器
 *
 * @package chaser\stream
 */
abstract class Server implements ServerInterface
{
    use Configuration, Service, Stream;

    /**
     * 监听网络标志组合
     *
     * @var int
     */
    protected static int $flags = STREAM_SERVER_BIND | STREAM_SERVER_LISTEN;

    /**
     * 常规配置
     *
     * @var array
     */
    protected array $configurations = [];

    /**
     * 本地地址
     *
     * @var string
     */
    protected string $localAddress;

    /**
     * 初始化
     *
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->localAddress = $address;
        $this->contextualize(['socket' => ['backlog' => self::BACKLOG]]);
    }

    /**
     * @inheritDoc
     */
    public function target(): string
    {
        return $this->localAddress;
    }

    /**
     * @inheritDoc
     */
    public function create()
    {
        if (!$this->stream) {

            $listening = self::listening();

            $context = stream_context_create($this->contextOptions);

            $this->stream = stream_socket_server($listening, $errno, $errStr, static::$flags, $context);

            if (!$this->stream) {
                throw new CreatedException("Server[$listening] create failed：$errno $errStr");
            }

            stream_set_blocking($this->stream, false);
        }

        return $this->stream;
    }
}
