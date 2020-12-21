<?php

declare(strict_types=1);

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\ServiceInterface;
use chaser\stream\interfaces\parts\StreamInterface;

/**
 * 流服务器
 *
 * @package chaser\stream\interfaces
 */
interface ServerInterface extends ServiceInterface, StreamInterface
{
    /**
     * 默认挂起连接数量上限
     */
    public const BACKLOG = 102400;

    /**
     * 服务器接收
     *
     * @return ConnectionInterface|array|false
     */
    public function accept();
}
