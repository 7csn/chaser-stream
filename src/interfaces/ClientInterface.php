<?php

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\CommonInterface;
use chaser\stream\interfaces\parts\CommunicationInterface;
use chaser\stream\interfaces\parts\ServiceInterface;

/**
 * 流客户端接口
 *
 * @package chaser\stream\interfaces
 */
interface ClientInterface extends CommonInterface, CommunicationInterface, ServiceInterface
{
}
