<?php

declare(strict_types=1);

namespace chaser\stream\traits;

/**
 * 监听网络
 *
 * @package chaser\stream\traits
 */
trait Stream
{
    /**
     * 主套接字流
     *
     * @var resource
     */
    protected $stream;

    /**
     * （套接字流）是否有效
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->stream && is_resource($this->stream);
    }

    /**
     * 返回套接字流
     *
     * @return resource
     */
    public function socket()
    {
        return $this->stream;
    }

    /**
     * 关闭
     *
     * @return bool
     */
    public function close(): bool
    {
        $close = $this->isActive() && fclose($this->stream);
        if ($close) {
            $this->stream = null;
        }
        return $close;
    }
}
