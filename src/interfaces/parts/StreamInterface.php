<?php

declare(strict_types=1);

namespace chaser\stream\parts;

/**
 * 监听网络
 *
 * @package chaser\stream\parts
 */
interface StreamInterface
{
    /**
     * （套接字流）是否有效
     *
     * @return bool
     */
    public function isActive(): bool;

    /**
     * 关闭
     *
     * @return bool
     */
    public function close(): bool;
}
