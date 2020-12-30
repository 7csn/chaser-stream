<?php

declare(strict_types=1);

namespace chaser\stream\events;

use chaser\stream\traits\PropertyReadable;

/**
 * （客户端）打开（服务器）连接失败
 *
 * @package chaser\stream\events
 */
class OpenConnectionFail
{
    use PropertyReadable;

    /**
     * 错误号
     *
     * @property-read int
     */
    protected int $errorNumber;

    /**
     * 错误消息
     *
     * @property-read string
     */
    protected string $errorMessage;

    /**
     * 初始化数据
     *
     * @param int $errorNumber
     * @param string $errorMessage
     */
    public function __construct(int $errorNumber, string $errorMessage)
    {
        $this->errorNumber = $errorNumber;
        $this->errorMessage = $errorMessage;
    }
}
