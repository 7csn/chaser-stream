<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\interfaces\part\ServiceInterface;

/**
 * 流服务特征
 *
 * @package chaser\stream\traits
 *
 * @see ServiceInterface
 */
trait Service
{
    /**
     * 获取网络监听地址
     *
     * @return string
     */
    public function getSocketAddress(): string
    {
        return static::transport() . '://' . $this->getTarget();
    }
}
