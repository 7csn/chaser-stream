<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\NetworkAddress;

/**
 * 通信
 *
 * @package chaser\stream\traits
 */
trait Communication
{
    /**
     * 远程地址
     *
     * @var string
     */
    protected string $remoteAddress;

    /**
     * 本地地址
     *
     * @var string
     */
    protected string $localAddress;

    /**
     * @inheritDoc
     */
    public function getRemoteAddress(): string
    {
        return $this->remoteAddress;
    }

    /**
     * @inheritDoc
     */
    public function getLocalAddress(): string
    {
        return $this->localAddress ??= (string)stream_socket_get_name($this->stream, false);
    }

    /**
     * 获取远程 IP
     *
     * @return false|string
     */
    public function getRemoteIp()
    {
        return NetworkAddress::getIp($this->getRemoteAddress());
    }

    /**
     * 获取远程 PORT
     *
     * @return false|int
     */
    public function getRemotePort()
    {
        return NetworkAddress::getPort($this->getRemoteAddress());
    }

    /**
     * 获取本地 IP
     *
     * @return false|string
     */
    public function getLocalIp()
    {
        return NetworkAddress::getIp($this->getLocalAddress());
    }

    /**
     * 获取本地 PORT
     *
     * @return int
     */
    public function getLocalPort()
    {
        return NetworkAddress::getPort($this->getLocalAddress());
    }

    /**
     * 是否 ipv4
     *
     * @return bool
     */
    public function isIpV4(): bool
    {
        return NetworkAddress::isIpV4($this->getRemoteAddress());
    }

    /**
     * 是否 ipv6
     *
     * @return bool
     */
    public function isIpV6(): bool
    {
        return NetworkAddress::isIpV6($this->getRemoteAddress());
    }
}
