<?php

namespace chaser\stream\interfaces;

use chaser\stream\exceptions\ClientCreatedException;
use chaser\stream\interfaces\parts\{CommonInterface, CommunicationInterface, ServiceInterface};

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
