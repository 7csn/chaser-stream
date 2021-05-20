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
     * 建立连接
     */
    public function connect();

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

    /**
     * 关闭套接字流资源
     */
    public function close(): void;
}
