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
    public function invalid(): bool
    {
        return !is_resource($this->stream) || feof($this->stream);
    }

    /**
     * @inheritDoc
     */
    public function socket()
    {
        return $this->stream;
    }

    /**
     * 关闭套接字资源
     */
    protected function closeSocket()
    {
        if (is_resource($this->stream)) {
            fclose($this->stream);
        }
        $this->stream = null;
    }
}
