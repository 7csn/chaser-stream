<?php

declare(strict_types=1);

namespace chaser\stream\interfaces;

use chaser\stream\exceptions\CreatedException;
use chaser\stream\interfaces\parts\{ContextInterface, HelperInterface, ServiceInterface};

/**
 * 流服务器
 *
 * @package chaser\stream\interfaces
 */
interface ServerInterface extends ServiceInterface, ContextInterface, HelperInterface
{
    /**
     * 默认挂起连接数量上限
     */
    public const BACKLOG = 102400;

    /**
     * 启动服务器
     *
     * @throws CreatedException
     */
    public function start();

    /**
     * 服务器接收
     */
    public function accept();

    /**
     * 停止服务器
     */
    public function stop();
}
