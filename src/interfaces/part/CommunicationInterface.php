<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\part;

/**
 * 通信部分接口
 *
 * @package chaser\stream\interfaces\part
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
     * 关闭通信连接
     */
    public function close(): void;
}
