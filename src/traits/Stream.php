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
     * @inheritDoc
     */
    public function isActive(): bool
    {
        return $this->stream && is_resource($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function socket()
    {
        return $this->stream;
    }

    /**
     * @inheritDoc
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
