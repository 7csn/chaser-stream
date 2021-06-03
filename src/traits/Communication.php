<?php

declare(strict_types=1);

namespace chaser\stream\traits;

use chaser\stream\interfaces\part\CommunicationInterface;

/**
 * 通信特征
 *
 * @package chaser\stream\traits
 *
 * @see CommunicationInterface
 */
trait Communication
{
    /**
     * 析构函数：关闭套接字流资源
     */
    public function __destruct()
    {
        $this->close();
    }
}
