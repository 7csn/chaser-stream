<?php

declare(strict_types=1);

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\CommunicationInterface;
use chaser\stream\interfaces\parts\ConfigurationInterface;
use chaser\stream\parts\ServiceInterface;
use chaser\stream\parts\StreamInterface;

/**
 * 流客户端
 *
 * @package chaser\stream\interfaces
 */
interface ClientInterface extends CommunicationInterface, ConfigurationInterface, ServiceInterface, StreamInterface
{

}
