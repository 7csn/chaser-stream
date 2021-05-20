<?php

namespace chaser\stream\interfaces\parts;

/**
 * 流服务部分接口
 *
 * @package chaser\stream\interfaces\parts
 */
interface ServiceInterface
{
    /**
     * 传输协议
     *
     * @return string
     */
    public static function transport(): string;

    /**
     * 获取套接字流地址
     *
     * @return string
     */
    public function getSocketAddress(): string;

    /**
     * 获取网络监听地址
     *
     * @return string
     */
    public function getTarget(): string;
}
