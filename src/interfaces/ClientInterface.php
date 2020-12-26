<?php

declare(strict_types=1);

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\CommunicationInterface;
use chaser\stream\interfaces\parts\ConfigurationInterface;
use chaser\stream\interfaces\parts\EventInterface;
use chaser\stream\interfaces\parts\ServiceInterface;
use chaser\stream\interfaces\parts\StreamInterface;

/**
 * 流客户端
 *
 * @package chaser\stream\interfaces
 */
interface ClientInterface extends CommunicationInterface, ConfigurationInterface, EventInterface, ServiceInterface, StreamInterface
{
    /**
     * 连接服务器
     */
    public function connect();
}
