<?php

namespace chaser\stream\interfaces;

use chaser\stream\exceptions\{ServerCreatedException, ServerPauseAcceptException, ServerResumeAcceptException};
use chaser\stream\interfaces\parts\{CommonInterface, ContextInterface, ServiceInterface};

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
     * 接受客户端连接/数据
     */
    public function accept(): void;

    /**
     * 停止服务器
     *
     * @throws ServerPauseAcceptException
     */
    public function stop(): void;
}
