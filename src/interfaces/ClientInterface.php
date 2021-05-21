<?php

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\{CommonInterface, CommunicationInterface, ServiceInterface};

/**
 * 流客户端接口
 *
 * @package chaser\stream\interfaces
 */
interface ClientInterface extends CommonInterface, CommunicationInterface, ServiceInterface
{
}
