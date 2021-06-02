<?php

namespace chaser\stream\interfaces\parts;

/**
 * 通信部分接口
 *
 * @package chaser\stream\interfaces\parts
 */
interface CommunicationInterface
{
    /**
     * 接收数据
     */
    public function receive(): void;

    /**
     * 发送数据
     *
     * @param string $data
     * @return bool
     */
    public function send(string $data): bool;

    /**
     * 关闭套接字流资源
     */
    public function close(): void;
}
