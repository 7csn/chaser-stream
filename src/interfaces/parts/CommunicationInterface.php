<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 通信
 *
 * @package chaser\stream\interfaces\parts
 */
interface CommunicationInterface
{
    /**
     * 获取远程地址
     *
     * @return string
     */
    public function getRemoteAddress(): string;

    /**
     * 获取本地地址
     *
     * @return string
     */
    public function getLocalAddress(): string;

    /**
     * 获取远程 IP
     *
     * @return false|string
     */
    public function getRemoteIp();

    /**
     * 获取远程 PORT
     *
     * @return false|int
     */
    public function getRemotePort();

    /**
     * 获取本地 IP
     *
     * @return false|string
     */
    public function getLocalIp();

    /**
     * 获取本地 PORT
     *
     * @return int
     */
    public function getLocalPort();

    /**
     * 是否 ipv4
     *
     * @return bool
     */
    public function isIpV4(): bool;

    /**
     * 是否 ipv6
     *
     * @return bool
     */
    public function isIpV6(): bool;

    /**
     * 接收数据
     *
     * @return false|string
     */
    public function receive();

    /**
     * 发送数据
     *
     * @param string $data
     * @return bool|int
     */
    public function send(string $data);
}
