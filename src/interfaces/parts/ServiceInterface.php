<?php

declare(strict_types=1);

namespace chaser\stream\parts;

use chaser\stream\exceptions\CreatedException;

/**
 * 流服务
 *
 * @package chaser\stream\parts
 */
interface ServiceInterface
{
    /**
     * 传输协议
     *
     * @return string
     */
    public static function transport(): string;

    /**
     * 上下文绑定配置
     *
     * @param array $options
     */
    public function contextualize(array $options);

    /**
     * 服务监听地址
     *
     * @return string
     */
    public function target(): string;

    /**
     * 创建监听服务套接字流
     *
     * @return resource
     * @throws CreatedException
     */
    public function create();
}
