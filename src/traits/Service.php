<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 流服务
 *
 * @package chaser\stream\traits
 */
trait Service
{
    /**
     * 获取监听地址
     *
     * @return string
     */
    public function socketAddress(): string
    {
        return static::transport() . '://' . $this->target();
    }
}
