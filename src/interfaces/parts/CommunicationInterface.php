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
     * 接收数据
     */
    public function receive();

    /**
     * 发送数据
     *
     * @param string $data
     */
    public function send(string $data);
}
