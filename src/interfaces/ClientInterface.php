<?php

declare(strict_types=1);

namespace chaser\stream\interfaces;

use chaser\stream\interfaces\parts\{CommunicationInterface, HelperInterface, ServiceInterface};

/**
 * 流客户端
 *
 * @package chaser\stream\interfaces
 */
interface ClientInterface extends ServiceInterface, CommunicationInterface, HelperInterface
{
}
