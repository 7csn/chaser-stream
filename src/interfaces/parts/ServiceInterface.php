<?php

declare(strict_types=1);

namespace chaser\stream\interfaces\parts;

/**
 * 流服务
 *
 * @package chaser\stream\interfaces\parts
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
     * 关闭流服务资源
     */
    public function close();
}
