<?php

declare(strict_types=1);

namespace chaser\stream\interfaces;

use chaser\stream\exception\ClientCreatedException;
use chaser\stream\interfaces\part\{CommonInterface, CommunicationInterface, ServiceInterface};

/**
 * 流客户端接口
 *
 * @package chaser\stream\interfaces
 */
interface ClientInterface extends CommonInterface, CommunicationInterface, ServiceInterface
{
    /**
     * 准备工作
     *
     * @throws ClientCreatedException
     */
    public function ready(): void;
}
