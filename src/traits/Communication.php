<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 通信
 *
 * @package chaser\stream\traits
 *
 * @property resource $stream
 */
trait Communication
{
    /**
     * 本地地址
     *
     * @var string
     */
    protected string $localAddress;

    /**
     * 远程地址
     *
     * @var string
     */
    protected string $remoteAddress;

    /**
     * @inheritDoc
     */
    public function getLocalAddress(): string
    {
        return $this->localAddress ??= (string)stream_socket_get_name($this->stream, false);
    }

    /**
     * @inheritDoc
     */
    public function getRemoteAddress(): string
    {
        return $this->remoteAddress;
    }
}
