<?php

namespace chaser\stream\interfaces;

use chaser\stream\exceptions\ServerCreatedException;
use chaser\stream\exceptions\ServerPauseAcceptException;
use chaser\stream\exceptions\ServerResumeAcceptException;
use chaser\stream\interfaces\parts\CommonInterface;
use chaser\stream\interfaces\parts\ContextInterface;
use chaser\stream\interfaces\parts\ServiceInterface;

/**
 * 流服务器接口
 *
 * @package chaser\stream\interfaces
 */
interface ServerInterface extends CommonInterface, ContextInterface, ServiceInterface
{
    /**
     * 默认挂起连接数量上限
     */
    public const BACKLOG = 102400;

    /**
     * 启动服务器
     *
     * @throws ServerCreatedException
     * @throws ServerResumeAcceptException
     */
    public function start(): void;

    /**
     * 停止服务器
     *
     * @throws ServerPauseAcceptException
     */
    public function stop(): void;
}
