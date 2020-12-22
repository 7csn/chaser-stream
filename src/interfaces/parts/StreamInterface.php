<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 监听网络
 *
 * @package chaser\stream\interfaces\parts
 */
interface StreamInterface
{
    /**
     * 套接字流是否有效
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * 获取套接字流
     *
     * @return resource
     */
    public function socket();

    /**
     * 关闭套接字流资源
     *
     * @return bool
     */
    public function close(): bool;
}
