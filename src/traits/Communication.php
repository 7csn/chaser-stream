<?php

namespace chaser\stream\traits;

use chaser\stream\interfaces\parts\CommunicationInterface;

/**
 * 通信特征
 *
 * @package chaser\stream\traits
 *
 * @see CommunicationInterface
 */
trait Communication
{
    /**
     * 本地地址
     *
     * @var string
     */
    private string $localAddress;

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
        return $this->localAddress ??= (string)stream_socket_get_name($this->socket, false);
    }

    /**
     * @inheritDoc
     */
    public function getRemoteAddress(): string
    {
        return $this->remoteAddress ??= (string)stream_socket_get_name($this->socket, true);
    }

    /**
     * 析构函数：关闭套接字流资源
     */
    public function __destruct()
    {
        $this->close();
    }
}
