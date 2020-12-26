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
     * 套接字是否失效
     *
     * @return bool
     */
    public function invalid(): bool;

    /**
     * 获取套接字流
     *
     * @return resource
     */
    public function socket();
}
